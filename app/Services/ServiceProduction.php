<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ServiceProduction
{
    /*
    |--------------------------------------------------------------------------
    | VIEW PRODUIT DTO
    |--------------------------------------------------------------------------
    */
    public function getAllProduitDto()
    {
        return DB::table('view_produit_dto')
            ->select([
                'PRODUIT_ID',
                'BAR_CODE',
                'REFERENCE',
                'NOM1',
                'NOM2',
                'NOM3',
                'DESIGNATION',
                'DISCRIPTION',
                'QUANTITE',
                'PRIX_ACHAT',
                'FRAIS_DIVERS',
                'MARGE',
                'PRIX_VENTE',
                'PRIX_VENTE_MINIMUM',
                'TTVA',
                'STOCK_SEUIL',
                'CATEGORIE_ID',
                'CATEGORIE_LIBELE',
                'FAMILLE_ID',
                'NOM',
                'UNITE_ID',
                'UNITE_LIBELE',
                'INVENTORIE',
                'COULEUR',
                'PHOTO',
                'INS_USER',
                'UPD_USER',
                'INS_DATE',
                'UPD_DATE',
                'is_materials',
                'is_manufactured',
                'is_active',
                'is_visible',
                'portion_gain',
                'shop_avg_price',
                'shop_last_price',
                'POID'
            ])
            ->orderBy('PRODUIT_ID', 'desc')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW PRODUIT
    |--------------------------------------------------------------------------
    */
    public function getAllProduits()
    {
        return DB::table('view_produit')
            ->select([
                'PRODUIT_ID',
                'REFERENCE',
                'NOM1',
                'NOM2',
                'NOM3',
                'DESIGNATION',
                'DISCRIPTION',
                'QUANTITE',
                'PRIX_ACHAT',
                'FRAIS_DIVERS',
                'MARGE',
                'PRIX_VENTE',
                'PRIX_VENTE_MINIMUM',
                'TTVA',
                'STOCK_SEUIL',
                'CATEGORIE',
                'FAMILLE_ID',
                'UNITE_ID',
                'INVENTORIE',
                'COULEUR',
                'PHOTO',
                'INS_USER',
                'UPD_USER',
                'INS_DATE',
                'UPD_DATE',
                'is_manufactured',
                'is_active',
                'is_visible',
                'portion_gain',
                'shop_avg_price',
                'shop_last_price',
                'POID',
                'Quantity'
            ])
            ->orderBy('PRODUIT_ID', 'desc')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW PRODUCTS
    |--------------------------------------------------------------------------
    */
    public function getAllProducts()
    {
        return DB::table('view_products')
            ->select([
                'PRODUIT_REFERENCE',
                'Product',
                'QUANTITE',
                '`1` as qty_1',
                'Livraison'
            ])
            ->orderBy('Product', 'desc')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW PROD PRODUCTIONS
    |--------------------------------------------------------------------------
    */
    public function getAllProdProductions()
    {
        return DB::table('view_prod_productions')
            ->select([
                'id',
                'reference',
                'date_starts',
                'date_ends',
                'outlay',
                'is_initiate',
                'is_finished',
                'is_active',
                'INS_USER',
                'INS_DATE',
                'UPD_USER',
                'UPD_DATE',
                'VALIDATION',
                'VALIDATION_DATE',
                'Name',
                'Remark',
                'task_id',
                'user_id',
                'FOURNISSEUR_ID',
                'Code_fournisseur',
                'Fournisseur',
                'LOGIN'
            ])
            ->orderBy('id', 'desc')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW PRODUCT AND ITS QUANTITY
    |--------------------------------------------------------------------------
    */
    public function getAllProductWithQuantity()
    {
        return DB::table('view_product_and_its_quantity')
            ->select([
                'produit_id',
                'quantity'
            ])
            ->orderBy('produit_id')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW PRODUCT MIN DETAILS
    |--------------------------------------------------------------------------
    */
    public function getAllProductMinDetails()
    {
        return DB::table('view_product_min_details')
            ->select([
                'PRODUIT_ID',
                'ref',
                'Produit',
                'Couleur',
                'Categorie',
                'Famille',
                'PU',
                'PA',
                'PMA',
                'PVMin',
                'FRAIS_DIVERS',
                'Seuil',
                'Marge',
                'PDA',
                'PRIX_BASE1',
                'PRIX_BASE2',
                'PRIX_REVIENT',
                'POID',
                'Qte',
                'INVENTORIE',
                'UNITE_ID',
                'Unite',
                'TTVA'
            ])
            ->orderBy('PRODUIT_ID', 'desc')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW PRODUCT MIN DETAILS 2
    |--------------------------------------------------------------------------
    */
    public function getAllProductMinDetails2()
    {
        return DB::table('view_product_min_details2')
            ->select([
                'depot_id',
                'PRODUIT_ID',
                'ref',
                'Produit',
                'Couleur',
                'Categorie',
                'Famille',
                'PU',
                'PA',
                'Qte',
                'UNITE_ID',
                'unite',
                'TTVA'
            ])
            ->orderBy('PRODUIT_ID', 'desc')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW PRODUCT STOCK DETAILS
    |--------------------------------------------------------------------------
    */
    public function getAllProductStockDetails()
    {
        return DB::table('view_product_stock_details')
            ->select([
                'PRODUIT_ID',
                'DESIGNATION',
                'is_manufactured',
                'PRIX_ACHAT',
                'PRIX_VENTE',
                DB::raw('`sum(IFNULL(s.QUANTITE,0))` as stock_total')
            ])
            ->orderBy('PRODUIT_ID')
            ->get();
    }

   
}
