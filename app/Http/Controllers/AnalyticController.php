<?php

namespace App\Http\Controllers;

use App\Services\AnalyticService;
use App\Services\AchatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

            $data = $this->analyticService->getArticleAnalysis($startDate, $endDate);

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
     * GET /api/analytic/article-analysis-delevered
     * Analyse des articles livrés / expédiés
     */
    public function articleAnalysisDelevered(Request $request): JsonResponse
    {
        try {
            $startDate = $request->query('startDate');
            $endDate = $request->query('endDate');

            $data = $this->analyticService->getArticleAnalysisDelevered($startDate, $endDate);

            return response()->json([
                'success' => true,
                'message' => 'Analyse des articles livrés récupérée avec succès.',
                'data'    => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'analyse des articles livrés.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/analytic/article-analysis-sales
     * Analyse détaillée des ventes d'articles
     */
    public function articleAnalysisSales(Request $request): JsonResponse
    {
        try {
            $startDate = $request->query('startDate');
            $endDate = $request->query('endDate');

            $data = $this->analyticService->getArticleAnalysisSales($startDate, $endDate);

            return response()->json([
                'success' => true,
                'message' => 'Analyse des ventes d\'articles récupérée avec succès.',
                'data'    => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'analyse des ventes.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/analytic/article-analysis-shopping
     * Analyse des achats et réceptions d'articles (Fait appel à AchatService)
     */
    public function articleAnalysisShopping(Request $request): JsonResponse
    {
        try {
            $startDate = $request->query('startDate');
            $endDate = $request->query('endDate');

            // Récupère l'analyse shopping optimisée sans vue SQL brute depuis AchatService
            $data = $this->achatService->getViewArticleAnalysisShopping($startDate, $endDate);

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
            // Par défaut, prend le Top 10 si aucune limite n'est passée
            $limit = $request->query('limit', 10);

            $data = $this->analyticService->getStockProduitTopSales($limit);

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