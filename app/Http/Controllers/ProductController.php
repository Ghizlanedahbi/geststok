<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /** Mouvements d'UNION */
    public function indexMovements(): JsonResponse
    {
        return response()->json($this->productService->getViewProducts());
    }

    /** Quantités groupées simples */
    public function indexQuantities(): JsonResponse
    {
        return response()->json($this->productService->getViewProductAndItsQuantity());
    }

    /** Fiches techniques minimales */
    public function indexMinDetails(): JsonResponse
    {
        return response()->json($this->productService->getViewProductMinDetails());
    }

    /** Détails stocks physiques */
    public function indexStockDetails(): JsonResponse
    {
        return response()->json($this->productService->getViewProductStockDetails());
    }

    /** Catalogue brut complet (33 colonnes) */
    public function indexFullDetails(): JsonResponse
    {
        return response()->json($this->productService->getViewProduit());
    }

    /** DTO (Relations aplaties avec libellés) */
    public function indexDtoDetails(): JsonResponse
    {
        return response()->json($this->productService->getViewProduitDto());
    }

    /** Suivi de fabrication / Usine */
    public function indexProductions(): JsonResponse
    {
        return response()->json($this->productService->getViewProductions());
    }
}
