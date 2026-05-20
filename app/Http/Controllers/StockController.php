<?php

namespace App\Http\Controllers;

use App\Services\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Exception;

class StockController extends Controller
{
    protected $stockService;

    /**
     * Injection du service de gestion de stock
     */
    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * Fonction interne pour standardiser l'enveloppe JSON des résultats paginés
     */
    private function paginatedResponse($paginator): JsonResponse
    {
        return response()->json([
            'success'    => true,
            'data'       => $paginator->items(),
            'pagination' => [
                'total'         => $paginator->total(),
                'per_page'      => $paginator->perPage(),
                'current_page'  => $paginator->currentPage(),
                'last_page'     => $paginator->lastPage(),
                'next_page_url' => $paginator->nextPageUrl(),
                'prev_page_url' => $paginator->previousPageUrl(),
            ]
        ], 200);
    }

    /**
     * Historique et mouvements détaillés (Vue: view_stock1)
     */
    public function indexStock1(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->stockService->getViewStock1((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Noyau du stock : Catalogue, Catégories, Familles (Vue: view_stock_managed_kernel)
     */
    public function indexStockKernel(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->stockService->getViewStockManagedKernel((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * État du stock consolidé avec jointures gauches (Vue: view_stock_new)
     */
    public function indexStockNew(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->stockService->getViewStockNew((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Quantités agrégées par produit et dépôt sans noms (Vue: view_stock_quantite)
     */
    public function indexStockQuantite(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->stockService->getViewStockQuantite((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Détails complets incluant fournisseurs et statuts (Vue: view_stock_detail)
     */
    public function indexStockDetail(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->stockService->getViewStockDetail((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Consolidation technique brute (Vue: view_stock_managed)
     */
    public function indexStockManaged(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->stockService->getViewStockManaged((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Stock groupé par dépôt uniquement (Vue: view_stock_by_deposit)
     */
    public function indexStockByDeposit(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->stockService->getViewStockByDeposit((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Stock classé par clés pour un produit spécifique (Vue: view_stock_classedbykeys)
     */
    public function indexStockClassedByKeys(Request $request): JsonResponse
    {
        try {
            $produitId = $request->query('produit_id', 7420);
            $perPage = $request->query('perPage', 15);
            $paginator = $this->stockService->getViewStockClassedByKeys($produitId, (int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
