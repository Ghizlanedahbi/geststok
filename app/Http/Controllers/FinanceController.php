<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FinanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class FinanceController extends Controller
{
    protected $financeService;

    /**
     * Injection de dépendance du service financier
     */
    public function __construct(FinanceService $financeService)
    {
        $this->financeService = $financeService;
    }

    /**
     * GET /api/finance/reglements-livraisons
     * Récupère la liste des règlements appliqués aux livraisons (avec remises et banques)
     */
    public function getReglementLivraisonRemise(): JsonResponse
    {
        try {
            $data = $this->financeService->getViewReglementLivraisonRemise();

            return response()->json([
                'success' => true,
                'message' => 'Règlements et livraisons récupérés avec succès.',
                'data'    => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des règlements.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/finance/operations-paiements
     * Récupère le journal global unifié (Livraisons BL et Avoirs AV)
     */
    public function getOperationPaiement(): JsonResponse
    {
        try {
            $data = $this->financeService->getViewOperationPaiement();

            return response()->json([
                'success' => true,
                'message' => 'Opérations de paiement récupérées avec succès.',
                'data'    => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des opérations de paiement.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}