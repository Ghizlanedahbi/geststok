<?php

namespace App\Services;

use App\Models\ProductMovement;
use App\Models\ProductStockQuantity;
use App\Models\ProductMinDetail;
use App\Models\ProductStockDetail;
use App\Models\ProductDetail;
use App\Models\Production;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ProductService
{
    /**
     * 1. VIEW_PRODUCTS
     * Historique global d'UNION (Livraisons, Réceptions, Stock initial).
     */
    public function getViewProducts(): Collection
    {
        return ProductMovement::query()
            ->select([
                'PRODUIT_REFERENCE',
                'Product',
                'QUANTITE',
                '1 as Type_id',
                'Livraison as Type_Libelle'
            ])
            ->get();
    }

    /**
     * 2. VIEW_PRODUCT_AND_ITS_QUANTITY
     * Liste rapide des stocks agrégés par ID produit.
     */
    public function getViewProductAndItsQuantity(): Collection
    {
        return ProductStockQuantity::query()
            ->select(['produit_id', 'quantity'])
            ->get();
    }

    /**
     * 3. VIEW_PRODUCT_MIN_DETAILS
     * Fiche technique condensée croisée avec les quantités de produits actifs.
     */
    public function getViewProductMinDetails(): Collection
    {
        return ProductMinDetail::query()
            ->from('stock_produit as p')
            ->select([
                'p.PRODUIT_ID', 'p.REFERENCE as ref',
                DB::raw("CONCAT(p.NOM1, IFNULL(CONCAT(p.NOM2, IFNULL(p.NOM3, '')), '')) AS Produit"),
                'p.COULEUR as Couleur', 'p.CATEGORIE_NAME as Categorie', 'p.FAMILLE_NAME as Famille',
                'p.PRIX_VENTE as PU', 'p.PRIX_ACHAT as PA', 'p.shop_avg_price as PMA',
                'p.PRIX_VENTE_MINIMUM as PVMin', 'p.FRAIS_DIVERS', 'p.STOCK_SEUIL as Seuil',
                'p.MARGE as Marge', 'p.shop_last_price as PDA', 'p.PRIX_BASE1', 'p.PRIX_BASE2',
                'p.PRIX_REVIENT', 'p.POID', DB::raw('SUM(s.quantity) AS Qte'), 'p.INVENTORIE',
                'p.UNITE_ID', 'p.UNITE_NAME as Unite', 'p.TTVA'
            ])
            ->leftJoin('stock_quantities as s', function($join) {
                $join->on('p.PRODUIT_ID', '=', 's.produit_id')->where('p.is_active', '<>', 0);
            })
            ->groupBy('p.PRODUIT_ID')
            ->get();
    }

    /**
     * 4. VIEW_PRODUCT_STOCK_DETAILS
     * Vérification de stock physique vs indicateur de fabrication.
     */
    public function getViewProductStockDetails(): Collection
    {
        return ProductStockDetail::query()
            ->from('stock_produit as p')
            ->select([
                'p.PRODUIT_ID', 'p.DESIGNATION', 'p.is_manufactured', 'p.PRIX_ACHAT', 'p.PRIX_VENTE',
                DB::raw('SUM(IFNULL(s.QUANTITE, 0)) AS `sum(IFNULL(s.QUANTITE,0))`')
            ])
            ->leftJoin('stock as s', 's.PRODUIT_ID', '=', 'p.PRODUIT_ID')
            ->groupBy('p.PRODUIT_ID')
            ->get();
    }

    /**
     * 5. VIEW_PRODUIT
     * Fiche produit exhaustive (33 colonnes) avec sous-requête de calcul de quantité.
     */
    public function getViewProduit(): Collection
    {
        return ProductDetail::query()
            ->from('stock_produit as p')
            ->select([
                'p.PRODUIT_ID', 'p.REFERENCE', 'p.NOM1', 'p.NOM2', 'p.NOM3',
                'p.DESIGNATION', 'p.DISCRIPTION', 'p.QUANTITE', 'p.PRIX_ACHAT',
                'p.FRAIS_DIVERS', 'p.MARGE', 'p.PRIX_VENTE', 'p.PRIX_VENTE_MINIMUM',
                'p.TTVA', 'p.STOCK_SEUIL', 'p.CATEGORIE_ID as CATEGORIE', 'p.FAMILLE_ID',
                'p.UNITE_ID', 'p.INVENTORIE', 'p.COULEUR', 'p.PHOTO', 'p.INS_USER',
                'p.UPD_USER', 'p.INS_DATE', 'p.UPD_DATE', 'p.is_manufactured',
                'p.is_active', 'p.is_visible', 'p.portion_gain', 'p.shop_avg_price',
                'p.shop_last_price', 'p.POID',
                DB::raw('(SELECT SUM(s.QUANTITE) FROM stock s WHERE p.PRODUIT_ID = s.PRODUIT_ID) AS Quantity')
            ])
            ->get();
    }

    /**
     * 6. VIEW_PRODUIT_DTO
     * Modèle de transfert aplati joignant Unités, Catégories et Familles.
     */
    public function getViewProduitDto(): Collection
    {
        return ProductDetail::query() // Utilisation réutilisable du query builder
            ->from('stock_produit as s')
            ->select([
                's.PRODUIT_ID', 's.BAR_CODE', 's.REFERENCE', 's.NOM1', 's.NOM2', 's.NOM3',
                's.DESIGNATION', 's.DISCRIPTION', 's.QUANTITE', 's.PRIX_ACHAT',
                's.FRAIS_DIVERS', 's.MARGE', 's.PRIX_VENTE', 's.PRIX_VENTE_MINIMUM',
                's.TTVA', 's.STOCK_SEUIL', 's.CATEGORIE_ID', 'c.CATEGORIE_LIBELE',
                's.FAMILLE_ID', 'fa.NOM as NOM', 's.UNITE_ID', 'u.UNITE_LIBELE',
                's.INVENTORIE', 's.COULEUR', 's.PHOTO', 's.INS_USER', 's.UPD_USER',
                's.INS_DATE', 's.UPD_DATE', 's.is_materials', 's.is_manufactured',
                's.is_active', 's.is_visible', 's.portion_gain', 's.shop_avg_price',
                's.shop_last_price', 's.POID'
            ])
            ->join('unite as u', 'u.UNITE_ID', '=', 's.UNITE_ID')
            ->join('stock_produits_categorie as c', 's.CATEGORIE_ID', '=', 'c.CATEGORIE_ID')
            ->leftJoin('stock_produits_categorie_famille as fa', 's.FAMILLE_ID', '=', 'fa.ID')
            ->get();
    }

    /**
     * 7. VIEW_PROD_PRODUCTIONS
     * Suivi de la chaîne de production/fabrication usine avec intervenants.
     */
    public function getViewProductions(): Collection
    {
        return Production::query()
            ->from('prod_productions as p')
            ->select([
                'p.id', 'p.reference', 'p.date_starts', 'p.date_ends', 'p.outlay',
                'p.is_initiate', 'p.is_finished', 'p.is_active', 'p.INS_USER',
                'p.INS_DATE', 'p.UPD_USER', 'p.UPD_DATE', 'p.VALIDATION',
                'p.VALIDATION_DATE', 'p.Name', 'p.Remark', 'p.task_id', 'p.user_id',
                'p.vendor_id as FOURNISSEUR_ID', 'f.FOURNISSEUR_CODE as Code_fournisseur',
                DB::raw("CONCAT(f.NOM, IFNULL(f.NOM2, '')) AS Fournisseur"),
                'u.LOGIN AS LOGIN'
            ])
            ->join('users as u', 'u.USER_ID', '=', 'p.user_id')
            ->leftJoin('achat_fournisseur as f', 'f.FOURNISSEUR_ID', '=', 'p.vendor_id')
            ->get();
    }
}
