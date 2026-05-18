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
     * Liste globale des ordres de transport (Vue: view_transport_order_details)
     * Regroupe responsables, conducteurs, véhicules et trajets.
     */
    public function indexOrders(): JsonResponse
    {
        return response()->json($this->transportService->getViewTransportOrderDetails());
    }

    /**
     * Liste des locations par client avec filtres (Vue: view_transport_order_locations)
     * Filtres possibles via URL: client_id, date_debut, date_fin
     */
    public function indexOrderLocations(Request $request): JsonResponse
    {
        $clientId  = $request->query('client_id');
        $dateDebut = $request->query('date_debut');
        $dateFin   = $request->query('date_fin');

        $data = $this->transportService->getViewTransportOrderLocations(
            $clientId ? (int)$clientId : null,
            $dateDebut,
            $dateFin
        );

        return response()->json($data);
    }

    /**
     * Détails étendus des locations (Vue: view_transport_location_client)
     * Inclut les matricules véhicules et les deux conducteurs.
     */
    public function indexLocationClient(): JsonResponse
    {
        return response()->json($this->transportService->getViewTransportLocationClient());
    }

    /**
     * Historique ligne par ligne (Vue: view_transport_details_line_by_line)
     * Basé sur l'UNION des Commandes, Livraisons, Personnel et Locations.
     */
    public function indexLineDetails(): JsonResponse
    {
        return response()->json($this->transportService->getViewTransportDetailsLineByLine());
    }
}