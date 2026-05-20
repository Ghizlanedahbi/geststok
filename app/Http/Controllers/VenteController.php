<?php

namespace App\Http\Controllers;

use App\Services\VenteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class VenteController extends Controller
{
    protected $venteService;

    /**
     * Constructeur avec injection du service Vente
     */
    public function __construct(VenteService $venteService)
    {
        $this->venteService = $venteService;
    }

    /**
     * Fonction helper interne pour standardiser les réponses paginées de l'API
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
     * 1. view_vente
     */
    public function indexVente(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVente((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 2. view_vente_avoir
     */
    public function indexVenteAvoir(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteAvoir((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 3. view_vente_avoirold
     */
    public function indexVenteAvoirOld(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteAvoirOld((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 4. view_vente_client
     */
    public function indexVenteClient(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteClient((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 5. view_vente_credit_bon_achat
     */
    public function indexVenteCreditBonAchat(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteCreditBonAchat((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 6. view_vente_credit_client
     */
    public function indexVenteCreditClient(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteCreditClient((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 7. view_vente_facture
     */
    public function indexVenteFacture(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteFacture((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 8. view_vente_jclient
     */
    public function indexVenteJClient(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteJClient((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 9. view_vente_livraison
     */
    public function indexVenteLivraison(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteLivraison((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 10. view_vente_livraison2
     */
    public function indexVenteLivraison2(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteLivraison2((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 11. view_vente_livraison_ligne
     */
    public function indexVenteLivraisonLigne(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteLivraisonLigne((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 12. view_vente_order_output
     */
    public function indexVenteOrderOutput(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteOrderOutput((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 13. view_vente_order_output_all
     */
    public function indexVenteOrderOutputAll(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteOrderOutputAll((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 14. view_vente_order_output_none_delivered
     */
    public function indexVenteOrderOutputNoneDelivered(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteOrderOutputNoneDelivered((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 15. view_vente_reglements_client
     */
    public function indexVenteReglementsClient(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteReglementsClient((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 16. view_vente_valide_reglement_livraison
     */
    public function indexVenteValideReglementLivraison(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewVenteValideReglementLivraison((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 17. view_sales_lines
     */
    public function indexSalesLines(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewSalesLines((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 18. view_sales_operation
     */
    public function indexSalesOperation(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewSalesOperation((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * 19. view_sales_operation_facture
     */
    public function indexSalesOperationFacture(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('perPage', 15);
            $paginator = $this->venteService->getViewSalesOperationFacture((int)$perPage);
            return $this->paginatedResponse($paginator);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
