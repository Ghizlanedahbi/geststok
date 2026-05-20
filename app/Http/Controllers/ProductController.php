<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Méthode interne pour structurer uniformément la réponse JSON paginée
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

    /** Mouvements d'UNION */
    public function indexMovements(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->productService->getViewProducts((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /** Quantités groupées simples */
    public function indexQuantities(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->productService->getViewProductAndItsQuantity((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /** Fiches techniques minimales */
    public function indexMinDetails(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->productService->getViewProductMinDetails((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /** Détails stocks physiques */
    public function indexStockDetails(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->productService->getViewProductStockDetails((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /** Catalogue brut complet (33 colonnes) */
    public function indexFullDetails(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->productService->getViewProduit((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /** DTO (Relations aplaties avec libellés) */
    public function indexDtoDetails(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->productService->getViewProduitDto((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /** Suivi de fabrication / Usine */
    public function indexProductions(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->productService->getViewProductions((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
