<?php

namespace App\Http\Controllers;

use App\Services\VenteService;
use Illuminate\Http\JsonResponse;

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
     * 1. view_vente
     */
    public function indexVente(): JsonResponse
    {
        $data = $this->venteService->getViewVente();

        return response()->json($data);
    }

    /**
     * 2. view_vente_avoir
     */
    public function indexVenteAvoir(): JsonResponse
    {
        $data = $this->venteService->getViewVenteAvoir();

        return response()->json($data);
    }

    /**
     * 3. view_vente_avoirold
     */
    public function indexVenteAvoirOld(): JsonResponse
    {
        $data = $this->venteService->getViewVenteAvoirOld();

        return response()->json($data);
    }

    /**
     * 4. view_vente_client
     */
    public function indexVenteClient(): JsonResponse
    {
        $data = $this->venteService->getViewVenteClient();

        return response()->json($data);
    }

    /**
     * 5. view_vente_credit_bon_achat
     */
    public function indexVenteCreditBonAchat(): JsonResponse
    {
        $data = $this->venteService->getViewVenteCreditBonAchat();

        return response()->json($data);
    }

    /**
     * 6. view_vente_credit_client
     */
    public function indexVenteCreditClient(): JsonResponse
    {
        $data = $this->venteService->getViewVenteCreditClient();

        return response()->json($data);
    }

    /**
     * 7. view_vente_facture
     */
    public function indexVenteFacture(): JsonResponse
    {
        $data = $this->venteService->getViewVenteFacture();

        return response()->json($data);
    }

    /**
     * 8. view_vente_jclient
     */
    public function indexVenteJClient(): JsonResponse
    {
        $data = $this->venteService->getViewVenteJClient();

        return response()->json($data);
    }

    /**
     * 9. view_vente_livraison
     */
    public function indexVenteLivraison(): JsonResponse
    {
        $data = $this->venteService->getViewVenteLivraison();

        return response()->json($data);
    }

    /**
     * 10. view_vente_livraison2
     */
    public function indexVenteLivraison2(): JsonResponse
    {
        $data = $this->venteService->getViewVenteLivraison2();

        return response()->json($data);
    }

    /**
     * 11. view_vente_livraison_ligne
     */
    public function indexVenteLivraisonLigne(): JsonResponse
    {
        $data = $this->venteService->getViewVenteLivraisonLigne();

        return response()->json($data);
    }

    /**
     * 12. view_vente_order_output
     */
    public function indexVenteOrderOutput(): JsonResponse
    {
        $data = $this->venteService->getViewVenteOrderOutput();

        return response()->json($data);
    }

    /**
     * 13. view_vente_order_output_all
     */
    public function indexVenteOrderOutputAll(): JsonResponse
    {
        $data = $this->venteService->getViewVenteOrderOutputAll();

        return response()->json($data);
    }

    /**
     * 14. view_vente_order_output_none_delivered
     */
    public function indexVenteOrderOutputNoneDelivered(): JsonResponse
    {
        $data = $this->venteService->getViewVenteOrderOutputNoneDelivered();

        return response()->json($data);
    }

    /**
     * 15. view_vente_reglements_client
     */
    public function indexVenteReglementsClient(): JsonResponse
    {
        $data = $this->venteService->getViewVenteReglementsClient();

        return response()->json($data);
    }

    /**
     * 16. view_vente_valide_reglement_livraison
     */
    public function indexVenteValideReglementLivraison(): JsonResponse
    {
        $data = $this->venteService->getViewVenteValideReglementLivraison();

        return response()->json($data);
    }

    /**
     * 17. view_sales_lines
     */
    public function indexSalesLines(): JsonResponse
    {
        $data = $this->venteService->getViewSalesLines();

        return response()->json($data);
    }

    /**
     * 18. view_sales_operation
     */
    public function indexSalesOperation(): JsonResponse
    {
        $data = $this->venteService->getViewSalesOperation();

        return response()->json($data);
    }

    /**
     * 19. view_sales_operation_facture
     */
    public function indexSalesOperationFacture(): JsonResponse
    {
        $data = $this->venteService->getViewSalesOperationFacture();

        return response()->json($data);
    }
}
