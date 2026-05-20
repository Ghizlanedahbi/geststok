<?php

namespace App\Http\Controllers;

use App\Services\TransportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransportController extends Controller
{
    protected $transportService;

    /**
     * Injection du service Transport
     */
    public function __construct(TransportService $transportService)
    {
        $this->transportService = $transportService;
    }

    /**
     * Liste globale des ordres de transport (Paginée)
     */
    public function indexOrders(Request $request): JsonResponse
    {
        $perPage = $request->query('perPage', 15);
        return response()->json($this->transportService->getViewTransportOrderDetails($perPage));
    }

    /**
     * Liste des locations par client avec filtres (Paginée)
     */
    public function indexOrderLocations(Request $request): JsonResponse
    {
        $clientId  = $request->query('client_id');
        $dateDebut = $request->query('date_debut');
        $dateFin   = $request->query('date_fin');
        $perPage   = $request->query('perPage', 15);

        $data = $this->transportService->getViewTransportOrderLocations(
            $clientId ? (int)$clientId : null,
            $dateDebut,
            $dateFin,
            $perPage
        );

        return response()->json($data);
    }

    /**
     * Détails étendus des locations (Paginée)
     */
    public function indexLocationClient(Request $request): JsonResponse
    {
        $perPage = $request->query('perPage', 15);
        return response()->json($this->transportService->getViewTransportLocationClient($perPage));
    }

    /**
     * Historique ligne par ligne sans vue SQL (Paginée)
     */
    public function indexLineDetails(Request $request): JsonResponse
    {
        $perPage = $request->query('perPage', 15);
        return response()->json($this->transportService->getViewTransportDetailsLineByLine($perPage));
    }
}