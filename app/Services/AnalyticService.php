<?php

namespace App\Services;

use App\Services\VenteService;
use Illuminate\Support\Facades\DB;
use Exception;

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
    public function getArticleAnalysisSales($startDate = null, $endDate = null, $perPage = 15)
    {
        try {
            $salesQuery = $this->getSalesLinesQuery($startDate, $endDate);

            return DB::table(DB::raw("({$salesQuery->toSql()}) as v"))
                ->mergeBindings($salesQuery)
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
                    'v.PRIX_UNITAIRE',
                    'v.TAUX_TVA',
                    'v.REMISE',
                    'v.REMISE_AMOUNT',
                    'v.Total',
                    'v.PRIX_ACHAT',
                    'v.Margin',
                    'c.CLIENT_CODE AS Code_client',
                    'c.NOM AS Client'
                ])
                ->join('vente_client as c', 'c.CLIENT_ID', '=', 'v.CLIENT_ID')
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'analyse des ventes d'articles.");
        }
    }

    /**
     * Analyse globale croisée des articles (Tous mouvements confondus)
     * Correspond à la logique brute de view_articleanalysis
     */
    public function getArticleAnalysis($startDate = null, $endDate = null, $perPage = 15)
    {
        try {
            return DB::table('view_articleanalysis')
                ->select(['PRODUIT_ID', 'DESIGNATION', 'QUANTITE_ACHETEE', 'MONTANT_TOTAL'])
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'analyse globale des articles.");
        }
    }

    /**
     * Classement des produits les plus vendus (Top Sales)
     * Correspond à la logique de view_stock_produit_top_sales
     */
    public function getStockProduitTopSales($limit = 10, $perPage = 15)
    {
        try {
            return DB::table('view_sales_lines as l')
                ->select([
                    'l.PRODUIT_ID',
                    'l.DESIGNATION',
                    DB::raw('SUM(IFNULL(l.QUANTITE, 0)) AS total_quantite'),
                    DB::raw('SUM(IFNULL(l.Total, 0)) AS total_montant')
                ])
                ->groupBy(['l.PRODUIT_ID', 'l.DESIGNATION'])
                ->orderBy('total_quantite', 'desc')
                ->limit($limit)
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du top des ventes.");
        }
    }

    /**
     * Helper pour centraliser la sous-requête de récupération des lignes de vente (view_sales_lines)
     */
    protected function getSalesLinesQuery($startDate = null, $endDate = null)
    {
        $query = DB::table('vente_livraison_ligne as l')
            ->select([
                'l.ID AS ID',
                DB::raw("'BL' AS Operation"),
                'lv.LIVRAISON_ID AS N°',
                'lv.CLIENT_ID AS CLIENT_ID',
                'l.PRODUIT_ID AS Produit_id',
                'l.PRODUIT_REFERENCE AS Reference_Produit',
                'l.DESIGNATION AS Designation',
                'l.QUANTITE AS Quantité',
                'l.PRIX_UNITAIRE AS PRIX_UNITAIRE',
                'l.TAUX_TVA AS TAUX_TVA',
                'l.REMISE AS REMISE',
                'l.REMISE_AMOUNT AS REMISE_AMOUNT',
                'l.Total AS Total',
                'l.INS_USER AS INS_USER',
                'l.INS_DATE AS INS_DATE',
                'l.UPD_USER AS UPD_USER',
                'l.UPD_DATE AS UPD_DATE',
                'lv.LIVRAISON_DATE AS LIVRAISON_DATE',
                'lv.VALIDATION_DATE AS Date_validation',
                'l.PRIX_ACHAT AS PRIX_ACHAT',
                'l.Margin AS Margin',
                'l.ShopPriceAvg AS ShopPriceAvg',
                'l.Color AS Couleur'
            ])
            ->join('vente_livraison as lv', 'lv.LIVRAISON_ID', '=', 'l.LIVRAISON_ID')
            ->where('lv.VALIDATION', 1);

        if ($startDate) {
            $query->where('lv.LIVRAISON_DATE', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('lv.LIVRAISON_DATE', '<=', $endDate);
        }

        return $query;
    }
}