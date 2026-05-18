<?php

namespace App\Http\Controllers;

use App\Services\AchatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AchatController extends Controller
{
    /**
     * Le service contenant la logique métier des requêtes.
     *
     * @var AchatService
     */
    protected $achatService;

    /**
     * Injection automatique du service AchatService.
     *
     * @param AchatService $achatService
     */
    public function __construct(AchatService $achatService)
    {
        $this->achatService = $achatService;
    }

    /**
     * Récupérer la liste des fournisseurs (Vue: view_achat_fournisseur)
     *
     * @return JsonResponse
     */
    public function indexViewFournisseurs(): JsonResponse
    {
        $fournisseurs = $this->achatService->getViewFournisseurs();

        return response()->json($fournisseurs);
    }

    /**
     * Récupérer la vue du journal fournisseur (Vue: view_achat_journal_fournisseur)
     *
     * @return JsonResponse
     */
    public function indexViewJournalFournisseur(): JsonResponse
    {
        $journal = $this->achatService->getViewJournalFournisseur();

        return response()->json($journal);
    }

    /**
     * Récupérer la vue des opérations d'achat (Vue: view_achat_operation)
     *
     * @return JsonResponse
     */
    public function indexViewAchatOperation(): JsonResponse
    {
        $operations = $this->achatService->getViewAchatOperation();

        return response()->json($operations);
    }

    /**
     * Récupérer la vue des réceptions d'achat (Vue: view_achat_reception)
     *
     * @return JsonResponse
     */
    public function indexViewAchatReception(): JsonResponse
    {
        $receptions = $this->achatService->getViewAchatReception();

        return response()->json($receptions);
    }

    /**
     * Récupérer la vue des réceptions pour paiement (Vue: view_achat_reception_4_paiement)
     *
     * @return JsonResponse
     */
    public function indexViewAchatReception4Paiement(): JsonResponse
    {
        $receptionsPaiement = $this->achatService->getViewAchatReception4Paiement();

        return response()->json($receptionsPaiement);
    }

    /**
     * Récupérer la vue des règlements fournisseurs (Vue: view_achat_reglement_fournisseur)
     *
     * @return JsonResponse
     */
    public function indexViewAchatReglementFournisseur(): JsonResponse
    {
        $reglements = $this->achatService->getViewAchatReglementFournisseur();

        return response()->json($reglements);
    }

    /**
     * Récupérer la vue de l'analyse des articles (Vue: view_articleanalysis)
     *
     * @return JsonResponse
     */
    public function indexViewArticleAnalysis(): JsonResponse
    {
        $analysis = $this->achatService->getViewArticleAnalysis();

        return response()->json($analysis);
    }

    /**
     * Récupérer la vue des lignes de vente (Vue: view_sales_lines)
     *
     * @return JsonResponse
     */
    public function indexViewReceptionAvoir(): JsonResponse
    {
        $receptionAvoirs = $this->achatService->getViewReceptionAvoir();

        return response()->json($receptionAvoirs);
    }

}
