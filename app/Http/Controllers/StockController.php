<?php

namespace App\Http\Controllers;

use App\Services\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
     * Historique et mouvements détaillés (Vue: view_stock1)
     */
    public function indexStock1(): JsonResponse
    {
        return response()->json($this->stockService->getViewStock1());
    }

    /**
     * Noyau du stock : Catalogue, Catégories, Familles (Vue: view_stock_managed_kernel)
     */
    public function indexStockKernel(): JsonResponse
    {
        return response()->json($this->stockService->getViewStockManagedKernel());
    }

    /**
     * État du stock consolidé avec jointures gauches (Vue: view_stock_new)
     */
    public function indexStockNew(): JsonResponse
    {
        return response()->json($this->stockService->getViewStockNew());
    }

    /**
     * Quantités agrégées par produit et dépôt sans noms (Vue: view_stock_quantite)
     */
    public function indexStockQuantite(): JsonResponse
    {
        return response()->json($this->stockService->getViewStockQuantite());
    }

    /**
     * Détails complets incluant fournisseurs et statuts (Vue: view_stock_detail)
     */
    public function indexStockDetail(): JsonResponse
    {
        return response()->json($this->stockService->getViewStockDetail());
    }

    /**
     * Consolidation technique brute (Vue: view_stock_managed)
     */
    public function indexStockManaged(): JsonResponse
    {
        return response()->json($this->stockService->getViewStockManaged());
    }

    /**
     * Stock groupé par dépôt uniquement (Vue: view_stock_by_deposit)
     */
    public function indexStockByDeposit(): JsonResponse
    {
        return response()->json($this->stockService->getViewStockByDeposit());
    }

    /**
     * Stock classé par clés pour un produit spécifique (Vue: view_stock_classedbykeys)
     */
    public function indexStockClassedByKeys(Request $request): JsonResponse
    {
        // On récupère l'ID 7420 par défaut si aucun ID n'est fourni dans l'URL
        $produitId = $request->query('produit_id', 7420);
        return response()->json($this->stockService->getViewStockClassedByKeys($produitId));
    }
}