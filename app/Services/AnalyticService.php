<?php

namespace App\Services;

use App\Services\VenteService;
use Illuminate\Support\Facades\DB;

class AnalyticService
{
    protected $venteService;

    public function __construct(VenteService $venteService)
    {
        $this->venteService = $venteService;
    }

    /**
     * Analyse des ventes (Basé sur view_articleanalysis_sales)
     * Jointure entre view_sales_lines et vente_client
     */
    public function getArticleAnalysisSales($startDate = null, $endDate = null)
    {
        $query = DB::table(DB::raw("({$this->getSalesLinesQuery($startDate, $endDate)->toSql()}) as v"))
            ->mergeBindings($this->getSalesLinesQuery($startDate, $endDate))
            ->select([
                DB::raw("CONCAT(v.ID, v.Operation) AS IDOP"),
                'v.N° AS livId',
                'v.Operation',
                'v.N°',
                'v.CLIENT_ID',
                'v.Produit_id',
                'v.Reference_Produit',
                'v.Designation',
                'v.Couleur',
                'v.ShopPriceAvg',
                'v.INS_DATE',
                'v.UPD_DATE',
                'v.LIVRAISON_DATE',
                'v.Date_validation',
                'v.Quantité',
                'v.TVA',
                'v.Remise',
                'v.Prix_de_vente',
                'v.Prix_achat',
                'v.Marge',
                'c.CLIENT_CODE as Code_client',
                'c.NOM as Client'
            ])
            ->join('vente_client as c', 'v.CLIENT_ID', '=', 'c.CLIENT_ID');

        return $query->get();
    }

    /**
     * Cette méthode reproduit la logique de votre méthode 17 (getViewSalesLines)
     * mais avec le support des filtres de date AVANT l'union pour la performance.
     */
    private function getSalesLinesQuery($startDate, $endDate)
    {
        // Segment Livraisons
        $livraisons = DB::table('vente_livraison_ligne as ll')
            ->select([
                DB::raw("'Livraison' as Operation"), 'll.ID', 'll.LIVRAISON_ID as N°', 'l.CLIENT_ID',
                'll.PRODUIT_ID as Produit_id', 'll.PRODUIT_REFERENCE as Reference_Produit',
                'll.DESIGNATION as Designation', 'll.Color as Couleur', 'll.ShopPriceAvg',
                'l.INS_DATE', 'l.UPD_DATE', 'l.LIVRAISON_DATE', 'l.VALIDATION_DATE as Date_validation',
                'll.QUANTITE as Quantité', 'll.FREE_QUANTITY', 'll.TAUX_TVA as TVA',
                'll.REMISE as Remise', 'll.PRIX_UNITAIRE as Prix_de_vente',
                'll.PRIX_ACHAT as Prix_achat', 'll.Margin as Marge'
            ])
            ->join('vente_livraison as l', 'll.LIVRAISON_ID', '=', 'l.LIVRAISON_ID')
            ->where('l.VALIDATION', '1')
            ->when($startDate, fn($q) => $q->where('l.LIVRAISON_DATE', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('l.LIVRAISON_DATE', '<=', $endDate));

        // Segment Avoirs
        $avoirs = DB::table('vente_avoir_ligne as ll')
            ->select([
                DB::raw("'Avoir' as Operation"), 'll.ID', 'll.AVOIR_ID as N°', 'l.CLIENT_ID',
                'll.PRODUIT_ID', 'll.PRODUIT_REFERENCE', 'll.DESIGNATION', 'll.Couleur',
                's.shop_avg_price as ShopPriceAvg', 'l.INS_DATE', 'l.UPD_DATE',
                'l.AVOIR_DATE as LIVRAISON_DATE', 'l.VALIDATION_DATE as Date_validation',
                'll.QUANTITE', 'll.FREE_QUANTITY', 'll.TAUX_TVA', 'll.REMISE',
                'll.PRIX_UNITAIRE', 'll.PRIX_ACHAT', 'll.Margin'
            ])
            ->join('vente_avoir as l', 'll.AVOIR_ID', '=', 'l.AVROIR_ID')
            ->join('stock_produit as s', 's.PRODUIT_ID', '=', 'll.PRODUIT_ID')
            ->where('l.VALIDATION', '1')
            ->when($startDate, fn($q) => $q->where('l.AVOIR_DATE', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('l.AVOIR_DATE', '<=', $endDate));

        // Segment Sorties
        $sorties = DB::table('vente_order_output_ligne as ol')
            ->select([
                DB::raw("'Sortie' as Operation"), 'ol.ID', 'ol.OUTPUT_ID as N°', 'o.CLIENT_ID',
                'ol.PRODUIT_ID', 'ol.PRODUIT_REFERENCE', 'ol.DESIGNATION', DB::raw("'Color'"),
                DB::raw('0'), DB::raw('NULL'), DB::raw('NULL'), 'o.LIVRAISON_DATE',
                DB::raw('NULL'), 'ol.QUANTITE', 'ol.FREE_QUANTITY', 'ol.TAUX_TVA',
                'ol.REMISE', 'ol.PRIX_UNITAIRE', 'ol.PRIX_UNITAIRE', 'ol.PRIX_ACHAT'
            ])
            ->join('vente_order_output as o', 'ol.OUTPUT_ID', '=', 'o.ID')
            ->whereNull('o.LIVRAISON_ID')
            ->when($startDate, fn($q) => $q->where('o.LIVRAISON_DATE', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('o.LIVRAISON_DATE', '<=', $endDate));

        return $livraisons->union($avoirs)->unionAll($sorties);
    }

    /**
     * Analyse des achats/shopping (Réceptions + Avoirs Fournisseurs)
     * Basé sur view_articleanalysis_shopping
     */
    public function getArticleAnalysisShopping($startDate = null, $endDate = null)
    {
        // 1. RC : Réceptions d'achats
        $receptions = DB::table('achat_reception_ligne as ll')
            ->select([
                DB::raw("'RC' AS Operation"),
                'll.RECEPTION_ID AS ReceptionOrAvoir',
                'll.PRODUIT_ID AS Produit_id',
                'll.PRODUIT_REFERENCE AS Reference_Produit',
                'll.DESIGNATION AS Designation',
                'll.Couleur AS Couleur',
                'c.FOURNISSEUR_CODE AS Code_Fournisseur',
                'c.NOM AS Fournisseur',
                'l.VALIDATION_DATE AS Date_validation',
                'll.QUANTITE AS PurchasedOrretour',
                'll.TAUX_TVA AS TVA',
                'll.REMISE AS Remise',
                'll.PRIX_UNITAIRE AS Prix_achat',
                'll.PRIX_VENTE AS Prix_de_vente'
            ])
            ->join('achat_reception as l', 'll.RECEPTION_ID', '=', 'l.RECEPTION_ID')
            ->join('achat_fournisseur as c', 'c.FOURNISSEUR_ID', '=', 'l.FOURNISSEUR_ID')
            ->where('l.VALIDATION', '1')
            ->when($startDate, fn($q) => $q->where('l.VALIDATION_DATE', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('l.VALIDATION_DATE', '<=', $endDate));

        // 2. AV : Avoirs Fournisseurs
        $returns = DB::table('achat_avoir_fournisseur_ligne as ll')
            ->select([
                DB::raw("'AV' AS Operation"),
                'll.AVOIR_FOURNISSEUR_ID',
                'll.PRODUIT_ID',
                'll.PRODUIT_REFERENCE',
                'll.DESIGNATION',
                'll.Couleur',
                'c.FOURNISSEUR_CODE',
                'c.NOM AS Client',
                'l.VALIDATION_DATE',
                'll.QUANTITE',
                'll.TAUX_TVA',
                'll.REMISE',
                'll.PRIX_UNITAIRE',
                'll.PRIX_VENTE'
            ])
            ->join('achat_avoir_fournisseur as l', 'll.AVOIR_FOURNISSEUR_ID', '=', 'l.AVOIR_FOURNISSEUR_ID')
            ->join('achat_fournisseur as c', 'c.FOURNISSEUR_ID', '=', 'l.FOURNISSEUR_ID')
            ->where('l.VALIDATION', '1')
            ->when($startDate, fn($q) => $q->where('l.VALIDATION_DATE', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('l.VALIDATION_DATE', '<=', $endDate));

        return $receptions->union($returns)->get();
    }

    /**
     * Analyse des achats détaillée (RC + AV + EN)
     * Basé sur view_article_analisis_shop
     */
    public function getArticleAnalysisShop($startDate = null, $endDate = null)
    {
        // 1. RC : Réceptions d'achat
        $receptions = DB::table('achat_reception_ligne as ll')
            ->select([
                DB::raw("'RC' AS Operation"),
                'll.RECEPTION_ID AS N°',
                'll.ID AS ID',
                DB::raw("CONCAT(ll.ID, 'RC') AS IDOP"),
                'l.REFERENCE',
                'l.FOURNISSEUR_ID',
                'll.PRODUIT_ID as Produit_id',
                'll.PRODUIT_REFERENCE as Reference_Produit',
                'll.DESIGNATION as Designation',
                'll.Couleur as Couleur',
                'c.FOURNISSEUR_CODE as Code_Fournisseur',
                'c.NOM as Fournisseur',
                'l.INS_DATE',
                'l.UPD_DATE',
                'l.RECEPTION_DATE',
                'l.VALIDATION_DATE as Date_validation',
                'll.QUANTITE as Quantite',
                'll.FREE_QUANTITY as Gratuit',
                'll.TAUX_TVA as TVA',
                DB::raw("((ll.PRIX_UNITAIRE * ll.QUANTITE) * ll.REMISE / 100) AS Remise"),
                'll.PRIX_UNITAIRE as Prix_achat',
                'll.PRIX_VENTE as Prix_de_vente'
            ])
            ->join('achat_reception as l', 'll.RECEPTION_ID', '=', 'l.RECEPTION_ID')
            ->join('achat_fournisseur as c', 'c.FOURNISSEUR_ID', '=', 'l.FOURNISSEUR_ID')
            ->where('l.VALIDATION', '1')
            ->when($startDate, fn($q) => $q->where('l.RECEPTION_DATE', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('l.RECEPTION_DATE', '<=', $endDate));

        // 2. AV : Avoirs Fournisseurs
        $avoirs = DB::table('achat_avoir_fournisseur_ligne as ll')
            ->select([
                DB::raw("'AV' AS Operation"),
                'll.AVOIR_FOURNISSEUR_ID',
                'll.ID',
                DB::raw("CONCAT(ll.ID, 'AVF') AS IDOP"),
                'l.REFERENCE',
                'l.FOURNISSEUR_ID',
                'll.PRODUIT_ID',
                'll.PRODUIT_REFERENCE',
                'll.DESIGNATION',
                'll.Couleur',
                'c.FOURNISSEUR_CODE',
                'c.NOM',
                'l.INS_DATE',
                'l.UPD_DATE',
                'l.AVOIR_FOURNISSEUR_DATE as RECEPTION_DATE',
                'l.VALIDATION_DATE',
                'll.QUANTITE',
                'll.FREE_QUANTITY',
                'll.TAUX_TVA',
                DB::raw("((ll.PRIX_UNITAIRE * ll.QUANTITE) * ll.REMISE / 100)"),
                'll.PRIX_UNITAIRE',
                'll.PRIX_VENTE'
            ])
            ->join('achat_avoir_fournisseur as l', 'll.AVOIR_FOURNISSEUR_ID', '=', 'l.AVOIR_FOURNISSEUR_ID')
            ->join('achat_fournisseur as c', 'c.FOURNISSEUR_ID', '=', 'l.FOURNISSEUR_ID')
            ->where('l.VALIDATION', '1')
            ->when($startDate, fn($q) => $q->where('l.AVOIR_FOURNISSEUR_DATE', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('l.AVOIR_FOURNISSEUR_DATE', '<=', $endDate));

        // 3. EN : Entrées (Order Input)
        $entrées = DB::table('vente_order_input_ligne as ol')
            ->select([
                DB::raw("'EN' AS Operation"),
                'o.ID as N°',
                'ol.ID',
                DB::raw("CONCAT(ol.ID, 'EN') AS IDOP"),
                'o.REFERENCE',
                'o.FOURNISSEUR_ID',
                'ol.PRODUIT_ID',
                'ol.PRODUIT_REFERENCE',
                'ol.DESIGNATION',
                DB::raw("'Color'"),
                'f.FOURNISSEUR_CODE',
                'f.NOM',
                'ol.INS_DATE',
                'ol.UPD_DATE',
                'o.RECEPTION_DATE',
                'o.VALIDATION_DATE',
                'ol.QUANTITE',
                DB::raw("0"),
                'ol.TAUX_TVA',
                DB::raw("((ol.PRIX_UNITAIRE * ol.QUANTITE) * ol.REMISE / 100)"),
                'ol.PRIX_UNITAIRE',
                'ol.PRIX_VENTE'
            ])
            ->join('vente_order_input as o', 'ol.INPUT_ID', '=', 'o.ID')
            ->join('achat_fournisseur as f', 'f.FOURNISSEUR_ID', '=', 'o.FOURNISSEUR_ID')
            ->where('o.VALIDATION', '1')
            ->when($startDate, fn($q) => $q->where('o.RECEPTION_DATE', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('o.RECEPTION_DATE', '<=', $endDate));

        return $receptions->union($avoirs)->union($entrées)->get();
    }

    /**
     * Croisement Factures, Livraisons et Lignes de Sorties
     * Basé sur view_facture_livraison_sortie_line
     */
    public function getFactureLivraisonSortieLines($startDate = null, $endDate = null)
    {
        return DB::table('view_vente_livraison_ligne as l')
            ->select([
                DB::raw("(CASE WHEN f.REFERENCE IS NULL THEN 'Livraison' ELSE 'Facture' END) AS OperationType"),
                'lv.REFERENCE AS Livraison',
                'f.REFERENCE AS Facture',
                DB::raw("(CASE WHEN f.REFERENCE IS NULL THEN l.REFERENCE ELSE f.REFERENCE END) AS Operation"),
                'l.REFERENCE AS REFERENCE',
                'l.ID AS ID',
                'l.LIVRAISON_ID AS LIVRAISON_ID',
                'l.PRODUIT_ID AS PRODUIT_ID',
                'l.PRODUIT_REFERENCE AS PRODUIT_REFERENCE',
                'l.DESIGNATION AS DESIGNATION',
                'l.UNITE_ID AS UNITE_ID',
                'l.QUANTITE AS QUANTITE',
                'l.QUANTITE2 AS QUANTITE2',
                'l.PRIX_UNITAIRE AS PRIX_UNITAIRE',
                'l.TAUX_TVA AS TAUX_TVA',
                'l.REMISE AS REMISE',
                'l.REMISE_AMOUNT AS REMISE_AMOUNT',
                'l.Total AS Total',
                'l.INS_USER AS INS_USER',
                'l.INS_DATE AS INS_DATE',
                'l.UPD_USER AS UPD_USER',
                'l.UPD_DATE AS UPD_DATE',
                'l.NOM1 AS NOM1',
                'l.NOM2 AS NOM2',
                'l.NOM3 AS NOM3',
                'l.PRODUCT_PROPERTY AS PRODUCT_PROPERTY',
                'l.DATE_EXPIRY AS DATE_EXPIRY',
                'l.PRIX_ACHAT AS PRIX_ACHAT',
                'l.Margin AS Margin',
                'l.ShopPriceAvg AS ShopPriceAvg',
                'l.POID AS POID',
                'l.Inventory AS Inventory',
                'l.OrderId AS OrderId',
                'l.FREE_QUANTITY AS FREE_QUANTITY',
                'l.OUTPUT_ID AS OUTPUT_ID',
                'l.Color AS Color'
            ])
            ->join('vente_livraison as lv', 'lv.LIVRAISON_ID', '=', 'l.LIVRAISON_ID')
            ->leftJoin('vente_facture as f', function ($join) {
                $join->on('f.LIVRAISON_ID', '=', 'l.LIVRAISON_ID')
                     ->where('f.VALIDATION', '=', 1);
            })
            ->when($startDate, fn($q) => $q->where('lv.LIVRAISON_DATE', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('lv.LIVRAISON_DATE', '<=', $endDate))
            ->get();
    }
}