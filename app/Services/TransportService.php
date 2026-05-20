<?php

namespace App\Services;

use App\Models\TransportLine;
use App\Models\TransportOrderHeader;
use App\Models\TransportLocationDetail;
use Illuminate\Support\Facades\DB;

class TransportService
{
    /**
     * VIEW_TRANSPORT_ORDER_DETAILS (ou VIEW_TRANSPORT_ORDERS)
     */
    public function getViewTransportOrderDetails($perPage = 15)
    {
        return TransportOrderHeader::query()
            ->from('transport_vehicule_ordre_header as o')
            ->select([
                'o.ID',
                DB::raw("CONCAT(u.NOM, ' ', u.PRENOM) AS Responsable"),
                DB::raw("CONCAT(c1.NOM, ' ', c1.PRENOM) AS Condicteur1"),
                DB::raw("CONCAT(c2.NOM, ' ', c2.PRENOM) AS Condicteur2"),
                DB::raw("CONCAT(v.MATRICULE, ' ', v.MODELE) AS Vehicule"),
                DB::raw("CONCAT(t.POINT_START, ' ', t.POINT_END) AS Trajet"),
                'o.DEPART AS Date_depart',
                'o.ARRIVE AS Date_arrivée',
                'o.POID AS Poid',
                'o.PRIX AS Montant',
                'o.VALIDATION AS Validé',
                'o.DATE_VALIDATION AS Date_validation',
                'o.REMARQUE AS Remarque'
            ])
            ->leftJoin('users as u', 'o.USER_ID', '=', 'u.USER_ID')
            ->leftJoin('transport_vehicule as v', 'o.VEHICULE_ID', '=', 'v.ID')
            ->leftJoin('transport_vehicule_trajet as t', 'o.TRAJET_ID', '=', 't.ID')
            ->leftJoin('transport_vehicule_conducteur as c1', 'c1.ID', '=', 'o.CONDICTEUR_ID')
            ->leftJoin('transport_vehicule_conducteur as c2', 'c2.ID', '=', 'o.CONDICTEUR_ID2')
            ->paginate($perPage);
    }

    /**
     * VIEW_TRANSPORT_ORDER_LOCATIONS (Avec Filtres)
     */
    public function getViewTransportOrderLocations(?int $clientId = null, ?string $dateDebut = null, ?string $dateFin = null, $perPage = 15)
    {
        return TransportLocationDetail::query()
            ->from('transport_vehicule_ordre_detail_location as l')
            ->select([
                'l.ID', 'o.ID AS OrderID', 'o.REFERENCE AS RefOrder', 'o.DATE_ORDER',
                'o.VALIDATION', 'l.REFERENCE', 'l.CLIENT_ID', 'f.REFERENCE AS Facture',
                'l.DESCRIPTION', 'f.FACTURE_DATE', 'f.FACTURE_ID', 'c.CLIENT_CODE', 'c.NOM',
                'l.SUB_TARJET', 't.POINT_START AS depart', 't.POINT_END AS arrivee',
                'l.PRODUIT_ID', 'p.REFERENCE AS Réf_service',
                DB::raw("CONCAT(p.NOM1, CONCAT(IFNULL(p.NOM2, ''), IFNULL(p.NOM3, ''))) AS Service"),
                'l.PRIX', 'l.NOMBRE_COLIS'
            ])
            ->join('transport_vehicule_ordre_header as o', 'o.ID', '=', 'l.ORDER_ID')
            ->leftJoin('transport_vehicule_trajet as t', 't.ID', '=', 'l.SUB_TARJET')
            ->leftJoin('vente_client as c', 'c.CLIENT_ID', '=', 'l.CLIENT_ID')
            ->leftJoin('stock_produit as p', 'p.PRODUIT_ID', '=', 'l.PRODUIT_ID')
            ->leftJoin('vente_facture as f', function($join) {
                $join->on('f.FACTURE_ID', '=', 'l.FACTURE_ID')->where('f.VALIDATION', '=', 1);
            })
            ->when($clientId, function ($query, $clientId) {
                return $query->where('l.CLIENT_ID', $clientId);
            })
            ->when($dateDebut, function ($query, $dateDebut) {
                return $query->whereDate('o.DATE_ORDER', '>=', $dateDebut);
            })
            ->when($dateFin, function ($query, $dateFin) {
                return $query->whereDate('o.DATE_ORDER', '<=', $dateFin);
            })
            ->paginate($perPage);
    }

    /**
     * VIEW_TRANSPORT_LOCATION_CLIENT
     */
    public function getViewTransportLocationClient($perPage = 15)
    {
        return TransportLocationDetail::query()
            ->from('transport_vehicule_ordre_detail_location as l')
            ->select([
                'l.TYPE', 'l.ID', 'l.DATE_DEPART', 'l.DATE_ARRIVER', 'l.PRODUIT_ID',
                'p.REFERENCE as Réf_service',
                DB::raw("CONCAT(p.NOM1, CONCAT(IFNULL(p.NOM2, ''), IFNULL(p.NOM3, ''))) AS Service"),
                'l.VEHICULE_ID', 'v.MATRICULE as Vehicule',
                'cn.NOM as Conducteur1', 'cn2.NOM as Conducteur2',
                'l.CONDUCTEUR1_ID', 'l.CONDUCTEUR2_ID',
                'o.ID as OrderID', 'o.REFERENCE as RefOrder', 'o.DATE_ORDER', 'o.VALIDATION',
                'l.REFERENCE', 'o.CLIENT_ID', 'f.REFERENCE as Facture', 'l.DESCRIPTION',
                'f.FACTURE_DATE', 'f.FACTURE_ID', 'c.CLIENT_CODE', 'c.NOM',
                'l.SUB_TARJET', 't.POINT_START as depart', 't.POINT_END as arrivee',
                'l.PRIX', 'l.POID', 'l.NOMBRE_COLIS'
            ])
            ->join('transport_vehicule_ordre_header as o', function($join) {
                $join->on('o.ID', '=', 'l.ORDER_ID')->where('l.TYPE', '=', 1);
            })
            ->leftJoin('transport_vehicule_trajet as t', 't.ID', '=', 'l.SUB_TARJET')
            ->leftJoin('vente_client as c', 'c.CLIENT_ID', '=', 'o.CLIENT_ID')
            ->leftJoin('vente_facture as f', function($join) {
                $join->on('f.FACTURE_ID', '=', 'l.FACTURE_ID')->where('f.VALIDATION', '=', 1);
            })
            ->leftJoin('transport_vehicule_conducteur as cn', 'cn.ID', '=', 'l.CONDUCTEUR1_ID')
            ->leftJoin('transport_vehicule_conducteur as cn2', 'cn2.ID', '=', 'l.CONDUCTEUR2_ID')
            ->leftJoin('stock_produit as p', 'p.PRODUIT_ID', '=', 'l.PRODUIT_ID')
            ->leftJoin('transport_vehicule as v', 'v.ID', '=', 'l.VEHICULE_ID')
            ->paginate($perPage);
    }

    /**
     * RECRÉATION SANS LA VUE SQL : Récupération ligne par ligne des détails de transport (Paginée)
     * Remplace l'appel à 'view_transport_line' par un ensemble d'unions via Query Builder.
     */
    public function getViewTransportDetailsLineByLine($perPage = 15)
    {
        // 1. Sous-requête Segment : Commandes de transport (Type 1)
        $commandesQuery = DB::table('transport_vehicule_ordre_detail_location as l1')
            ->select([
                'l1.ID', 'l1.ORDER_ID', 'l1.CLIENT_ID', 'l1.FACTURE_ID',
                'l1.REFERENCE as Référence', 'l1.DATE_ARRIVER as Arrivée', 
                'l1.DESCRIPTION as Description', 'l1.PRIX as Prix',
                DB::raw("'Commande' as type")
            ])
            ->where('l1.TYPE', '=', 1);

        // 2. Sous-requête Segment : Livraisons de transport (Type 2)
        $livraisonsQuery = DB::table('transport_vehicule_ordre_detail_location as l2')
            ->select([
                'l2.ID', 'l2.ORDER_ID', 'l2.CLIENT_ID', 'l2.FACTURE_ID',
                'l2.REFERENCE as Référence', 'l2.DATE_ARRIVER as Arrivée', 
                'l2.DESCRIPTION as Description', 'l2.PRIX as Prix',
                DB::raw("'Livraison' as type")
            ])
            ->where('l2.TYPE', '=', 2);

        // 3. Sous-requête Segment : Personnel de transport (Type 3)
        $personnelQuery = DB::table('transport_vehicule_ordre_detail_location as l3')
            ->select([
                'l3.ID', 'l3.ORDER_ID', 'l3.CLIENT_ID', 'l3.FACTURE_ID',
                'l3.REFERENCE as Référence', 'l3.DATE_ARRIVER as Arrivée', 
                'l3.DESCRIPTION as Description', 'l3.PRIX as Prix',
                DB::raw("'Personnel' as type")
            ])
            ->where('l3.TYPE', '=', 3);

        // 4. Sous-requête Segment : Locations de transport (Type 4)
        $locationsQuery = DB::table('transport_vehicule_ordre_detail_location as l4')
            ->select([
                'l4.ID', 'l4.ORDER_ID', 'l4.CLIENT_ID', 'l4.FACTURE_ID',
                'l4.REFERENCE as Référence', 'l4.DATE_ARRIVER as Arrivée', 
                'l4.DESCRIPTION as Description', 'l4.PRIX as Prix',
                DB::raw("'Location' as type")
            ])
            ->where('l4.TYPE', '=', 4);

        // Union complète et propre de l'ensemble des segments
        $unionQuery = $commandesQuery
            ->union($livraisonsQuery)
            ->union($personnelQuery)
            ->union($locationsQuery);

        // On applique les jointures finales (Headers, Factures, Clients) sur l'ensemble fédéré
        return DB::table(DB::raw("({$unionQuery->toSql()}) as c"))
            ->mergeBindings($unionQuery)
            ->select([
                'c.ID', 
                'o.DATE_ORDER as Date_order', 
                'o.REFERENCE as RefOrder', 
                'o.VALIDATION',
                'vc.CLIENT_ID as clientId', 
                'vc.CLIENT_CODE', 
                'vc.NOM as Client',
                'c.type', 
                'c.Référence', 
                'c.Arrivée', 
                'c.Description', 
                'c.FACTURE_ID',
                'c.ORDER_ID', 
                'c.Prix', 
                'o.DEPART as Depart', 
                'o.ARRIVE as Arrivée_order',
                'f.REFERENCE as RéfFacture'
            ])
            ->join('transport_vehicule_ordre_header as o', 'c.ORDER_ID', '=', 'o.ID')
            ->leftJoin('vente_facture as f', 'c.FACTURE_ID', '=', 'f.FACTURE_ID')
            ->leftJoin('vente_client as vc', 'vc.CLIENT_ID', '=', 'c.CLIENT_ID')
            ->paginate($perPage);
    }
}