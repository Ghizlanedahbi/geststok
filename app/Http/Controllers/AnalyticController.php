<?php

namespace App\Http\Controllers;

use App\Services\AnalyticService;
use App\Services\AchatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Exception;

class AnalyticController extends Controller
{
    protected $analyticService;
    protected $achatService;

    /**
     * Injection des services analytique et achat
     */
    public function __construct(AnalyticService $analyticService, AchatService $achatService)
    {
        $this->analyticService = $analyticService;
        $this->achatService = $achatService;
    }

    /**
     * GET /api/analytic/article-analysis
     * Analyse globale croisée des articles (Tous mouvements confondus)
     */
    public function articleAnalysis(Request $request): JsonResponse
    {
        try {
            $startDate = $request->query('startDate');
            $endDate = $request->query('endDate');
            $perPage = $request->query('perPage', 15);

            $data = $this->analyticService->getArticleAnalysis($startDate, $endDate, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Analyse globale des articles récupérée avec succès.',
                'data'    => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'analyse globale des articles.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/analytic/article-analysis-sales
     * Analyse détaillée des ventes d'articles (Filtres dates + Clients)
     */
    public function articleAnalysisSales(Request $request): JsonResponse
    {
        try {
            $startDate = $request->query('startDate');
            $endDate = $request->query('endDate');
            $perPage = $request->query('perPage', 15);

            $data = $this->analyticService->getArticleAnalysisSales($startDate, $endDate, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Analyse des ventes d\'articles récupérée avec succès.',
                'data'    => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'analyse des ventes d\'articles.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/analytic/article-analysis-shopping
     * Analyse détaillée des achats d'articles
     */
    public function articleAnalysisShopping(Request $request): JsonResponse
    {
        try {
            $startDate = $request->query('startDate');
            $endDate = $request->query('endDate');
            $perPage = $request->query('perPage', 15);

            // Appel au service externe AchatService en y passant le paramètre perPage
            $data = $this->achatService->getViewArticleAnalysisShopping($startDate, $endDate, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Analyse des achats d\'articles récupérée avec succès.',
                'data'    => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'analyse des achats.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/analytic/stock-produit-top-sales
     * Classement des produits les plus vendus (Top Sales)
     */
    public function stockProduitTopSales(Request $request): JsonResponse
    {
        try {
            // Limite globale du classement (Top 10 par défaut)
            $limit = $request->query('limit', 10);
            // Nombre d'éléments par page (15 par défaut)
            $perPage = $request->query('perPage', 15);

            $data = $this->analyticService->getStockProduitTopSales($limit, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Top des ventes récupéré avec succès.',
                'data'    => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'extraction du top des ventes.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}