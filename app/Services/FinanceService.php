<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class FinanceService
{
    /**
     * 1. VIEW_REGLEMENT_LIVRAISON_REMISE
     * Suivi croisé des règlements validés appliqués aux livraisons, avec remises et banques.
     */
    public function getViewReglementLivraisonRemise(): Collection
    {
        return DB::table('vente_reglements_client as r')
            ->select([
                'lv.LIVRAISON_ID AS LIVRAISON_ID',
                'r.REGLEMENT_ID AS REGLEMENT_ID',
                'r.banque_id AS BANQUE_ID',
                'm.MODE_PAIMENT_ID AS MODE_PAIMENT_ID',
                'f.FACTURE_ID AS FACTURE_ID',
                'c.CLIENT_ID AS CLIENT_ID',
                'c.CLIENT_CODE AS CLIENT_CODE',
                'c.NOM AS CLIENT',
                'r.REFERENCE AS REF_REGLEMENT',
                'r.REGLEMENT_DATE AS REGLEMENT_DATE',
                'lv.REFERENCE AS REF_LIVRAISON',
                'lv.LIVRAISON_DATE AS LIVRAISON_DATE',
                'f.REFERENCE AS REF_FACTURE',
                'f.FACTURE_DATE AS FACTURE_DATE',
                'lv.MONTANT_TOTAL AS MONTANT_INITIAL',
                'r.MONTANT AS MONTANT_PAYE',
                'r.Rebate AS REMISE_APPLIQUEE',
                'r.DESCRIPTION AS DESCRIPTION',
                'm.MODE_PAIMANT AS MODE_PAIMANT',
                'p.nom AS BANQUE'
            ])
            ->join('vente_reglement_livraison as rv', function ($join) {
                $join->on('r.REGLEMENT_ID', '=', 'rv.reglement_id')
                     ->where('r.VALIDATION', '=', 1)
                     ->where('rv.validate', '=', 1);
            })
            ->join('vente_livraison as lv', 'rv.livraison_id', '=', 'lv.LIVRAISON_ID')
            ->join('vente_client as c', 'c.CLIENT_ID', '=', 'lv.CLIENT_ID')
            ->leftJoin('vente_facture as f', 'f.FACTURE_ID', '=', 'lv.FactureId')
            ->join('modes_paiement as m', 'm.MODE_PAIMENT_ID', '=', 'r.MODE_DE_PAIMENT_ID')
            ->leftJoin('param_banque as p', 'p.id', '=', 'r.banque_id')
            ->get();
    }

    /**
     * 2. VIEW_OPERATION_PAIEMENT (UNION SANS APPEL DE VIEW)
     * Récupère de manière globale toutes les opérations financières (Livraisons VS Avoirs Clients).
     */
    public function getViewOperationPaiement(): Collection
    {
        // Étape A : Extraction de la logique interne brute de 'view_livraison_paiement'
        $livraisonsQuery = DB::table('vente_livraison as l')
            ->select([
                DB::raw("'BL' AS Type"),
                'l.MONTANT_TOTAL AS Montant',
                'l.LIVRAISON_ID AS N°',
                'l.REFERENCE AS Réf',
                'l.LIVRAISON_DATE AS Date_operation',
                'f.REFERENCE AS Facture',
                'l.CLIENT_ID AS CLIENT_ID',
                'c.CLIENT_CODE AS Code_Client',
                'c.NOM AS Client',
                'l.TotalRemise AS Remise',
                'l.PAYED AS Payed',
                DB::raw("(l.MONTANT_TOTAL - l.PAYED) AS open_price")
            ])
            ->join('vente_client as c', 'c.CLIENT_ID', '=', 'l.CLIENT_ID')
            ->leftJoin('vente_facture as f', 'f.FACTURE_ID', '=', 'l.FactureId');

        // Étape B : Extraction et déconstruction complète de 'view_avoir_paiement' & 'view_vente_avoir'
        $avoirsQuery = DB::table('vente_avoir as a')
            ->select([
                DB::raw("'AV' AS Type"),
                DB::raw("CAST(-IFNULL(a.MONTANT_TOTAL, 0) AS DECIMAL(10,2)) AS Montant"),
                'a.AVROIR_ID AS N°',
                'a.REFERENCE AS Réf',
                'a.AVOIR_DATE AS Date_operation',
                DB::raw("NULL AS Facture"),
                'a.CLIENT_ID AS CLIENT_ID',
                'c.CLIENT_CODE AS Code_Client',
                'c.NOM AS Client',
                'a.TOTAL_REMISE AS Remise',
                'a.PAYED AS Payed',
                DB::raw("(-a.MONTANT_TOTAL + a.PAYED) AS open_price")
            ])
            ->join('vente_client as c', 'c.CLIENT_ID', '=', 'a.CLIENT_ID');

        // Étape C : Union stable des deux segments d'opérations
        $unionQuery = $livraisonsQuery->union($avoirsQuery);

        // Étape D : Sélection finale par rapport à la structure de base
        return DB::table(DB::raw("({$unionQuery->toSql()}) as op"))
            ->mergeBindings($unionQuery)
            ->select([
                'op.Type',
                'op.Montant',
                'op.N°',
                'op.Réf',
                'op.Date_operation',
                'op.Facture',
                'op.CLIENT_ID',
                'op.Code_Client',
                'op.Client',
                'op.Remise',
                'op.Payed',
                'op.open_price'
            ])
            ->get();
    }
}