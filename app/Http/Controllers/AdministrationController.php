<?php

namespace App\Http\Controllers;

use App\Services\AdministrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Exception;

class AdministrationController extends Controller
{
    protected $adminService;

    /**
     * Injection du service dans le constructeur
     */
    public function __construct(AdministrationService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Récupère la liste détaillée des charges (Paginée)
     */
    public function getCharges(Request $request): JsonResponse
    {
        try {
            // Récupère la valeur de 'perPage', par défaut à 15 si absente
            $perPage = $request->query('perPage', 15);
            
            $charges = $this->adminService->getViewCharges($perPage);
            
            return response()->json([
                'success' => true,
                'data'    => $charges
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des charges.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupère la liste des utilisateurs (Paginée)
     */
    public function getUsers(Request $request): JsonResponse
    {
        try {
            // Récupère la valeur de 'perPage', par défaut à 15 si absente
            $perPage = $request->query('perPage', 15);
            
            $users = $this->adminService->getViewUsers($perPage);
            
            return response()->json([
                'success' => true,
                'data'    => $users
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des utilisateurs.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}