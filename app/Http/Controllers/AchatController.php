<?php

namespace App\Http\Controllers;

use App\Services\AchatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Exception;

class AchatController extends Controller
{
    protected $achatService;

    public function __construct(AchatService $achatService)
    {
        $this->achatService = $achatService;
    }

    public function indexViewFournisseurs(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $fournisseurs = $this->achatService->getViewFournisseurs($perPage);
            return response()->json(['success' => true, 'data' => $fournisseurs], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function indexViewJournalFournisseur(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $journal = $this->achatService->getViewJournalFournisseur($perPage);
            return response()->json(['success' => true, 'data' => $journal], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function indexViewAchatOperation(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $operations = $this->achatService->getViewAchatOperation($perPage);
            return response()->json(['success' => true, 'data' => $operations], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function indexViewAchatReception(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $receptions = $this->achatService->getViewAchatReception($perPage);
            return response()->json(['success' => true, 'data' => $receptions], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function indexViewAchatReception4Paiement(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $receptionsPaiement = $this->achatService->getViewAchatReception4Paiement($perPage);
            return response()->json(['success' => true, 'data' => $receptionsPaiement], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function indexViewAchatReglementFournisseur(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $reglements = $this->achatService->getViewAchatReglementFournisseur($perPage);
            return response()->json(['success' => true, 'data' => $reglements], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function indexViewArticleAnalysis(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $analysis = $this->achatService->getViewArticleAnalysis($perPage);
            return response()->json(['success' => true, 'data' => $analysis], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function indexViewReceptionAvoir(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $receptionAvoirs = $this->achatService->getViewReceptionAvoir($perPage);
            return response()->json(['success' => true, 'data' => $receptionAvoirs], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}