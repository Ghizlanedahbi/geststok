<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\StockProduit;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * VIEW_STOCK1
     * Liste détaillée et historique des mouvements avec libellé du dépôt.
     */
    public function getViewStock1()
    {
        return Stock::query()
            ->from('stock as s')
            ->select([
                'd.DEPOT_LIBELE as Dépot', 's.STOCK_ID', 's.REFERENCE', 's.TYPE_MOUVEMENT',
                's.TYPE_MOUVEMENT_ID', 's.STOCK_DATE', 's.DEPOT_ID', 's.DEPOT_NOM',
                's.LOT_ID', 's.LOT_NOM', 's.PRODUIT_ID', 's.PRODUIT_REFERENCE',
                's.DESIGNATION', 's.UNITE_ID', 's.UNITE', 's.FOURNISSEUR_ID',
                's.FOURNISSEUR_NOM', 's.CODE_BARRE', 's.INVENTORIE', 's.STATUT_ID',
                's.SATATUT', 's.REMARQUE', 's.QUANTITE', 's.PRIX_ACHAT',
                's.PRIX_ACHAT_PAR_DEFAUT', 's.PRIX_VENTE', 's.PRIX_VENTE_PAR_DEFAUT',
                's.INS_DATE', 's.UPD_USER', 's.UPD_DATE', 's.INS_USER',
                's.lineId', 's.RefType', 's.MOVE_TYPE_ID as move_type_id', 's.DATE_EXPIRY'
            ])
            ->join('stock_depot as d', 'd.DEPOT_ID', '=', 's.DEPOT_ID')
            ->get();
    }

    /**
     * VIEW_STOCK_MANAGED_KERNEL
     * Catalogue complet incluant catégories, familles et prix calculés.
     */
    public function getViewStockManagedKernel()
    {
        return StockProduit::query()
            ->from('stock_quantities as s')
            ->select([
                'p.REFERENCE as Réf',
                DB::raw("CONCAT(p.NOM1, IFNULL(p.NOM2, ''), IFNULL(p.NOM3, '')) AS Désignation"),
                'p.PRIX_ACHAT as PA', 'p.PRIX_VENTE as PV', 'p.PRIX_VENTE_MINIMUM as PVM',
                'p.STOCK_SEUIL as Seuil', 'p.MARGE as Marge', 'p.FRAIS_DIVERS as Frais_divers',
                'st.STATUT_NOM as Statut', 'p.COULEUR as Couleur', 'c.CATEGORIE_LIBELE as Categorie',
                'fm.NOM as famille', 'u.UNITE_LIBELE as Unité', 'f.NOM as Fournisseur',
                'd.DEPOT_LIBELE as Dépot', 's.id', 's.produit_id', 's.depot_id', 's.unit_id',
                's.statut_id', 's.fournisseur_id', 's.shop_price as PA_STOCK', 's.quantity'
            ])
            ->join('stock_produit as p', 'p.PRODUIT_ID', '=', 's.produit_id')
            ->join('stock_produit_statut as st', 'st.STATUT_ID', '=', 's.statut_id')
            ->join('unite as u', 'u.UNITE_ID', '=', 's.unit_id')
            ->leftJoin('achat_fournisseur as f', 'f.FOURNISSEUR_ID', '=', 's.fournisseur_id')
            ->join('stock_produits_categorie as c', 'c.CATEGORIE_ID', '=', 'p.CATEGORIE_ID')
            ->leftJoin('stock_produits_categorie_famille as fm', 'fm.ID', '=', 'p.FAMILLE_ID')
            ->join('stock_depot as d', 'd.DEPOT_ID', '=', 's.depot_id')
            ->get();
    }

    /**
     * VIEW_STOCK_NEW
     * Consolidation avec jointure gauche pour assurer l'affichage des stocks orphelins.
     */
    public function getViewStockNew()
    {
        return Stock::query()
            ->from('stock')
            ->select([
                'stock_produit.PRODUIT_ID', 'stock.PRODUIT_REFERENCE as REFERENCE',
                'stock.DESIGNATION', 'stock.UNITE', 'stock_produit.COULEUR as Couleur',
                'stock_produit.PRIX_ACHAT', 'stock.PRIX_ACHAT as StockPRIX_ACHAT',
                'stock_produit.PRIX_VENTE', 'stock_produit.MARGE', 'stock_produit.STOCK_SEUIL',
                'stock_produit.INVENTORIE', 'stock.DEPOT_ID', 'stock.DEPOT_NOM',
                'stock.FOURNISSEUR_ID as VendorId', 'stock.FOURNISSEUR_NOM as VendorName',
                'stock.STATUT_ID as Statut_Id', DB::raw('SUM(stock.QUANTITE) as Quantité')
            ])
            ->leftJoin('stock_produit', 'stock_produit.PRODUIT_ID', '=', 'stock.PRODUIT_ID')
            ->groupBy([
                'stock_produit.PRODUIT_ID', 'stock.PRODUIT_REFERENCE', 'stock.DESIGNATION',
                'stock.UNITE', 'stock_produit.COULEUR', 'stock_produit.PRIX_ACHAT',
                'stock.PRIX_ACHAT', 'stock_produit.PRIX_VENTE', 'stock_produit.MARGE',
                'stock_produit.STOCK_SEUIL', 'stock_produit.INVENTORIE', 'stock.DEPOT_ID',
                'stock.DEPOT_NOM', 'stock.FOURNISSEUR_ID', 'stock.FOURNISSEUR_NOM', 'stock.STATUT_ID'
            ])
            ->get();
    }

    /**
     * VIEW_STOCK_QUANTITE
     * État des quantités simplifié (IDs uniquement pour Unités et Dépôts).
     */
    public function getViewStockQuantite()
    {
        return StockProduit::query()
            ->from('stock_produit')
            ->select([
                'stock_produit.PRODUIT_ID', 'stock_produit.REFERENCE',
                DB::raw("CONCAT(stock_produit.NOM1, IFNULL(stock_produit.NOM2, ''), IFNULL(stock_produit.NOM3, '')) AS DESIGNATION"),
                'stock.PRIX_ACHAT', 'stock_produit.FRAIS_DIVERS', 'stock_produit.COULEUR as Couleur',
                'stock_produit.MARGE', 'stock_produit.PRIX_VENTE', 'stock_produit.STOCK_SEUIL',
                'stock.DEPOT_ID', 'stock.UNITE_ID', DB::raw('SUM(stock.QUANTITE) as Quantité')
            ])
            ->join('stock', 'stock_produit.PRODUIT_ID', '=', 'stock.PRODUIT_ID')
            ->groupBy([
                'stock_produit.PRODUIT_ID', 'stock_produit.REFERENCE', 'stock_produit.NOM1',
                'stock_produit.NOM2', 'stock_produit.NOM3', 'stock.PRIX_ACHAT',
                'stock_produit.FRAIS_DIVERS', 'stock_produit.MARGE', 'stock_produit.PRIX_VENTE',
                'stock_produit.STOCK_SEUIL', 'stock.DEPOT_ID', 'stock.UNITE_ID'
            ])
            ->get();
    }

    /**
     * VIEW_STOCK_DETAIL
     * Version complète avec noms des fournisseurs et statuts.
     */
    public function getViewStockDetail()
    {
        return StockProduit::query()
            ->from('stock_produit')
            ->select([
                'stock_produit.PRODUIT_ID', 'stock_produit.REFERENCE',
                DB::raw("CONCAT(stock_produit.NOM1, IFNULL(stock_produit.NOM2, ''), IFNULL(stock_produit.NOM3, '')) AS DESIGNATION"),
                'stock_produit.PRIX_ACHAT', 'stock_produit.FRAIS_DIVERS', 'stock_produit.COULEUR as Couleur',
                'stock_produit.MARGE', 'stock_produit.PRIX_VENTE', 'stock_produit.STOCK_SEUIL',
                'stock_produit.INVENTORIE', 'stock.DEPOT_ID', 'stock.DEPOT_NOM', 'stock.UNITE',
                'stock.FOURNISSEUR_ID as VendorId', 'stock.FOURNISSEUR_NOM as VendorName',
                'stock.STATUT_ID as StatusID', 'stock.SATATUT as StatusName',
                'stock.QUANTITE as Quantité', 'stock.PRIX_ACHAT as StockPRIX_ACHAT'
            ])
            ->join('stock', 'stock_produit.PRODUIT_ID', '=', 'stock.PRODUIT_ID')
            ->groupBy([
                'stock_produit.PRODUIT_ID', 'stock_produit.REFERENCE', 'stock_produit.NOM1',
                'stock_produit.NOM2', 'stock_produit.NOM3', 'stock_produit.PRIX_ACHAT',
                'stock_produit.FRAIS_DIVERS', 'stock_produit.MARGE', 'stock_produit.PRIX_VENTE',
                'stock_produit.STOCK_SEUIL', 'stock_produit.INVENTORIE', 'stock.DEPOT_ID',
                'stock.DEPOT_NOM', 'stock.UNITE', 'stock.FOURNISSEUR_ID', 'stock.FOURNISSEUR_NOM',
                'stock.STOCK_ID', 'stock.SATATUT'
            ])
            ->get();
    }

    /**
     * VIEW_STOCK_MANAGED
     * Consolidation technique brute par dimensions clés.
     */
    public function getViewStockManaged()
    {
        return Stock::query()
            ->select([
                'PRODUIT_ID', 'DEPOT_ID', 'UNITE_ID', 'STATUT_ID', 'FOURNISSEUR_ID',
                'PRIX_ACHAT as StockPRIX_ACHAT', DB::raw('SUM(QUANTITE) as Quantité')
            ])
            ->groupBy(['PRODUIT_ID', 'DEPOT_ID', 'UNITE_ID', 'STATUT_ID', 'FOURNISSEUR_ID', 'PRIX_ACHAT'])
            ->get();
    }

    /**
     * VIEW_STOCK_CLASSEDBYKEYS
     * Filtrage spécifique sur le produit ID 7420 (Défaut).
     */
    public function getViewStockClassedByKeys($produitId = 7420)
    {
        return Stock::query()
            ->select([
                'PRODUIT_ID', 'DEPOT_ID', 'UNITE_ID', 'STATUT_ID', 'FOURNISSEUR_ID',
                'PRIX_ACHAT', DB::raw('SUM(QUANTITE) as total_quantite')
            ])
            ->where('PRODUIT_ID', '=', $produitId)
            ->groupBy(['PRODUIT_ID', 'DEPOT_ID', 'UNITE_ID', 'STATUT_ID', 'FOURNISSEUR_ID', 'PRIX_ACHAT'])
            ->get();
    }

    /**
     * VIEW_STOCK_BY_DEPOSIT
     * Somme simplifiée des stocks par Dépôt.
     */
    public function getViewStockByDeposit()
    {
        return Stock::query()
            ->select(['PRODUIT_ID', 'DEPOT_ID', DB::raw('SUM(QUANTITE) as total_quantite')])
            ->groupBy(['PRODUIT_ID', 'DEPOT_ID'])
            ->get();
    }
}