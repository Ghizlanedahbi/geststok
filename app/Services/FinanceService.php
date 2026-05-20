<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class FinanceService
{
    /**
     * 1. VIEW_REGLEMENT_LIVRAISON_REMISE
     * Suivi croisé des règlements validés appliqués aux livraisons, avec remises et banques.
     */
    public function getViewReglementLivraisonRemise($perPage = 15)
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
                'm.MODE_PAIMANT AS Mode_Paiement',
                'b.NOM AS Banque',
                'r.INS_USER AS INS_USER',
                'r.INS_DATE AS INS_DATE',
                'r.UPD_USER AS UPD_USER',
                'r.UPD_DATE AS UPD_DATE'
            ])
            ->join('vente_reglement_livraison as rl', 'rl.REGLEMENT_ID', '=', 'r.REGLEMENT_ID')
            ->join('vente_livraison as lv', 'lv.LIVRAISON_ID', '=', 'rl.LIVRAISON_ID')
            ->join('vente_client as c', 'c.CLIENT_ID', '=', 'r.CLIENT_ID')
            ->join('modes_paiement as m', 'm.MODE_PAIMENT_ID', '=', 'r.MODE_PAIMENT_ID')
            ->leftJoin('param_banque as b', 'b.id', '=', 'r.banque_id')
            ->leftJoin('vente_facture as f', 'f.LIVRAISON_ID', '=', 'lv.LIVRAISON_ID')
            ->where('r.VALIDATION', '=', 1)
            ->paginate($perPage);
    }

    /**
     * 2. VIEW_OPERATION_PAIEMENT
     * Journal global unifié unissant les ventes réelles (BL) et les avoirs émis (AV)
     */
    public function getViewOperationPaiement($perPage = 15)
    {
        // Étape A : Extraction stable du segment 'Vente Livraison'
        $livraisonsQuery = DB::table('vente_livraison as l')
            ->select([
                DB::raw("'BL' AS Type"),
                DB::raw("CAST(IFNULL(l.MONTANT_TOTAL, 0) AS DECIMAL(10,2)) AS Montant"),
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
            ->leftJoin('vente_facture as f', function ($join) {
                $join->on('f.LIVRAISON_ID', '=', 'l.LIVRAISON_ID')
                     ->where('f.VALIDATION', '<>', 0);
            })
            ->where('l.VALIDATION', '=', 1);

        // Étape B : Extraction stable du segment 'Vente Avoir'
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

        // Étape D : Sélection finale paginée
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
            ->paginate($perPage);
    }
}