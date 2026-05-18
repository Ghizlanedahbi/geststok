<?php

namespace App\Services;

use App\Models\AchatAvoirFournisseur;
use App\Models\AchatCreditFournisseur;
use App\Models\AchatFournisseur;
use App\Models\AchatJournalFournisseur;
use App\Models\AchatReception;
use App\Models\AchatReglementFournisseur;
use Illuminate\Support\Facades\DB;

class AchatService
{
    /*
    |--------------------------------------------------------------------------
    | VIEW_ACHAT_AVOIR_FOURNISSEUR
    |--------------------------------------------------------------------------
    */

    public function getAvoirFournisseur()
    {
        return AchatAvoirFournisseur::query()

            ->from('achat_avoir_fournisseur as a')

            ->select([
                'a.AVOIR_FOURNISSEUR_ID',
                'a.RECEPTION_ID',
                'a.REFERENCE',
                'a.AVOIR_FOURNISSEUR_DATE',
                'a.FOURNISSEUR_ID',
                'a.TOTAL_HT',
                'a.MONTANT_TOTAL',
                'a.TOTAL_TVA',
                'a.VALIDATION',
                'a.VALIDATION_DATE',
                'a.INS_DATE',
                'a.INS_USER',
                'a.UPD_DATE',
                'a.UPD_USER',
                'a.USER_ID',
                'a.DEPOT_ID',

                DB::raw('IFNULL(SUM(c.MONTANT),0) AS Payed'),

                'j.DEBIT as JDebut',

                'a.FOURNISSEUR_CODE',

                DB::raw('a.FOURNISSEUR_NAME as Fournisseur'),

                DB::raw('a.DEPOT_NAME as Depot'),

                DB::raw('u.NOM as Utilisateur'),
            ])

            ->leftJoin(
                'users as u',
                'u.USER_ID',
                '=',
                'a.USER_ID'
            )

            ->leftJoin(
                'achat_journal_fournisseur as j',
                'j.JOURNAL_FOURNISSEUR_ID',
                '=',
                'a.JOURNAL_ID'
            )

            ->leftJoin(
                'achat_credit_fournisseur as c',
                function ($join) {
                    $join->on(
                        'a.AVOIR_FOURNISSEUR_ID',
                        '=',
                        'c.AvoirId'
                    )
                    ->where('c.VALIDATION', 1);
                }
            )

            ->groupBy('a.AVOIR_FOURNISSEUR_ID')

            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW_ACHAT_CREDIT_FOURNISSEUR
    |--------------------------------------------------------------------------
    */

    public function getCreditFournisseur()
    {
        return AchatCreditFournisseur::query()

            ->from('achat_credit_fournisseur as c')

            ->select([

                'c.CREDIT_ID',
                'c.FOURNISSEUR_ID',
                'c.JOURNAL_ID',
                'c.REFERENCE',
                'c.REFERENCE_OPERATION',
                'c.DESCRIPTION',
                'c.CREDIT_DATE',
                'c.MONTANT',
                'c.VALIDATION',
                'c.VALIDATION_DATE',
                'c.INS_USER',
                'c.INS_DATE',
                'c.UPD_USER',
                'c.UPD_DATE',
                'c.AvoirId',

                DB::raw('c.PaiementNo as Numero'),

                DB::raw('c.PaiementEcheance as Echeance'),

                DB::raw('c.mode_paiement as mode_paiement_id'),

                DB::raw('c.holder as Proprietaire'),

                'c.mode_paiement_text',

                'c.bank_id',

                'c.user_id',

                'c.is_credit',

                'f.FOURNISSEUR_CODE',

                DB::raw("
                    CONCAT(
                        f.NOM,
                        IFNULL(f.NOM2,'')
                    ) as Fournisseur
                "),

                DB::raw('u.NOM as Utilisateur'),

                DB::raw('m.MODE_PAIMANT as Mode_Paiement'),

                DB::raw('b.nom as Banque'),
            ])

            ->join(
                'achat_fournisseur as f',
                'c.FOURNISSEUR_ID',
                '=',
                'f.FOURNISSEUR_ID'
            )

            ->leftJoin(
                'users as u',
                'c.user_id',
                '=',
                'u.USER_ID'
            )

            ->leftJoin(
                'modes_paiement as m',
                'c.mode_paiement',
                '=',
                'm.MODE_PAIMENT_ID'
            )

            ->leftJoin(
                'param_banque as b',
                'c.bank_id',
                '=',
                'b.nom'
            )

            ->get();
    }
/*
    |--------------------------------------------------------------------------
    | VIEW_ACHAT_FOURNISSEUR
    |--------------------------------------------------------------------------
    */

    public function getViewFournisseurs()
    {
        return AchatFournisseur::query()

            ->from('achat_fournisseur as c')

            ->select([
                'c.FOURNISSEUR_ID',
                'c.FOURNISSEUR_CODE',
                'c.NOM',
                'c.NOM2',
                'c.ADRESSE',
                'c.VILLE',
                'c.TEL',
                'c.GSM',
                'c.FAXE',
                'c.CONTACT',
                'c.MAIL',
                'c.LOGO',
                'c.IF',
                'c.PATENTE',
                'c.RC',
                'c.CNSS',
                'c.FOURNISSEUR_CATEGORIE_ID',
                'c.ICE',
                'c.DEFAUT',
                'c.INS_USER',
                'c.INS_DATE',
                'c.UPD_USER',
                'c.UPD_DATE',
                'ct.FOURNISSEUR_CATEGORIE_LIBELE',
            ])

            ->leftJoin(
                'achat_fournisseur_categorie as ct',
                'c.FOURNISSEUR_CATEGORIE_ID',
                '=',
                'ct.FOURNISSEUR_CATEGORIE_ID'
            )

            ->get();
    }
    /*
    |--------------------------------------------------------------------------
    | VIEW_ACHAT_JOURNAL_FOURNISSEUR
    |--------------------------------------------------------------------------
    */

    public function getViewJournalFournisseur()
    {
        return AchatJournalFournisseur::query()

            ->from('achat_journal_fournisseur as j')

            ->select([
                'j.JOURNAL_FOURNISSEUR_ID',
                'j.FOURNISSEUR_ID',
                'j.REFERENCE',
                'j.OPERATION_DATE',
                'j.DESCRIPTION',
                'j.DEBIT',
                'j.CREDIT',
                'j.INS_USER',
                'j.INS_DATE',
                'j.UPD_USER',
                'j.UPD_DATE',
                'j.RCERPTION_REFERENCE',
                'j.lineId',
                'j.type',
                'j.cancled',

                DB::raw('j.mode_paiement as mode_paiement_id'),

                'j.mode_paiementText',
                'j.user_id',
                'j.lock_out',
                'j.lock_out_date',
                'j.operation',
                'j.echeance',
                'j.bank_id',
                'j.RebatePortion',
                'j.Rebate',

                'f.FOURNISSEUR_CODE',

                DB::raw("CONCAT(f.NOM, IFNULL(f.NOM2, '')) as Fournisseur"),

                DB::raw('u.LOGIN as LOGIN'),

                DB::raw('m.MODE_PAIMANT as MODE_PAIMANT'),

                DB::raw('b.nom as Banque'),

                'f.TEL',
            ])

            ->join(
                'achat_fournisseur as f',
                'f.FOURNISSEUR_ID',
                '=',
                'j.FOURNISSEUR_ID'
            )

            ->leftJoin(
                'modes_paiement as m',
                'm.MODE_PAIMENT_ID',
                '=',
                'j.mode_paiement'
            )

            ->leftJoin(
                'param_banque as b',
                'b.id',
                '=',
                'j.bank_id'
            )

            ->leftJoin(
                'users as u',
                'u.USER_ID',
                '=',
                'j.user_id'
            )

            ->get();
    }
    /*
    |--------------------------------------------------------------------------
    | VIEW_ACHAT_OPERATION
    |--------------------------------------------------------------------------
    */

    public function getViewAchatOperation()
    {
        // 1. Première partie : achat_reception
        $receptions = \App\Models\AchatReception::query()

            ->from('achat_reception as r')

            ->select([
                'r.FOURNISSEUR_ID',
                'f.FOURNISSEUR_CODE as Code_fournisseur',

                DB::raw("CONCAT(CONCAT(f.NOM, ' '), IFNULL(f.NOM2, ' ')) as Fournisseur"),

                'r.REFERENCE as Réf',
                'r.RECEPTION_DATE as Date',

                DB::raw("IF(LENGTH(TRIM(r.REFERENCE_FACTURE)) > 0, 'Facture', 'Livraison') as Type"),
                DB::raw("IF(LENGTH(TRIM(r.REFERENCE_FACTURE)) > 0, r.REFERENCE_FACTURE, r.REFERENCE_ORIGINE) as Réf_operation"),
                DB::raw("IF(LENGTH(TRIM(r.REFERENCE_FACTURE)) > 0, r.DATE_FACTURE, r.DATE_ORIGINE) as Date_operation"),

                'r.TOTAL_TVA as Total_TVA',
                'r.TotalRemise as Total_Remise',
                'r.TOTAL_HT as HT',
                'r.MONTANT_TOTAL as Montant',
                'r.MONTANT_TOTAL_REEL as Montant_réel',

                DB::raw("(r.MONTANT_TOTAL_REEL - r.MONTANT_TOTAL) as Escompte"),

                'r.REMISE_GLOBAL as Remise_escompte',
                'r.CHARGE_GLOBAL as Charge_escompte',
            ])

            ->join(
                'achat_fournisseur as f',
                'f.FOURNISSEUR_ID',
                '=',
                'r.FOURNISSEUR_ID'
            );

        // 2. Deuxième partie : achat_avoir_fournisseur engagée avec le UNION ALL
        return \App\Models\AchatAvoirFournisseur::query()

            ->from('achat_avoir_fournisseur as a')

            ->select([
                'a.FOURNISSEUR_ID',
                'f2.FOURNISSEUR_CODE as Code_fournisseur',

                DB::raw("CONCAT(CONCAT(f2.NOM, ' '), IFNULL(f2.NOM2, '')) as Fournisseur"),

                'a.REFERENCE as Réf',
                'a.AVOIR_FOURNISSEUR_DATE as Date',

                DB::raw("'Avoir' as Type"),
                'a.REFERENCE as Réf_operation',
                'a.AVOIR_FOURNISSEUR_DATE as Date_operation',

                'a.TOTAL_TVA as Total_TVA',
                'a.TotalRemise as Total_Remise',
                'a.TOTAL_HT as HT',
                'a.MONTANT_TOTAL as Montant',

                DB::raw("0 as Montant_réel"),
                DB::raw("0 as Escompte"),
                DB::raw("0 as Remise_escompte"),
                DB::raw("0 as Charge_escompte"),
            ])

            ->join(
                'achat_fournisseur as f2',
                'f2.FOURNISSEUR_ID',
                '=',
                'a.FOURNISSEUR_ID'
            )

            ->unionAll($receptions)

            ->get();
    }
    /*
    |--------------------------------------------------------------------------
    | VIEW_ACHAT_RECEPTION
    |--------------------------------------------------------------------------
    */

    public function getViewAchatReception()
    {
        return AchatReception::query()

            ->from('achat_reception as r')

            ->select([
                'r.COMMANDE_ID',
                'r.RECEPTION_ID',
                'r.REFERENCE',
                'r.RECEPTION_DATE',

                DB::raw('r.COMMANDE_REF as Commande'),
                DB::raw('r.REFERENCE_ORIGINE as Livraison'),
                DB::raw('r.DATE_ORIGINE as Date_livraison'),
                DB::raw('r.REFERENCE_FACTURE as Facture'),
                DB::raw('r.DATE_FACTURE as Date_facture'),

                'r.AVOIR_COMPLET_REF',
                'r.FOURNISSEUR_CODE',
                'r.FOURNISSEUR_ID',

                DB::raw('r.FOURNISSEUR_NAME as Fournisseur'),
                DB::raw('r.MONTANT_TOTAL as Total_TTC'),
                DB::raw('r.MONTANT_TOTAL_REEL as Montant_réel'),
                DB::raw('r.TOTAL_HT as Total_HT'),
                DB::raw('r.TotalRemise as TotalRemise'),

                'r.REMISE_GLOBAL',
                'r.REMISE_PORTION_GLOBAL',

                DB::raw('j.RebatePortion as Remise_pourcentage'),

                'r.CHARGE_GLOBAL',
                'r.CHARGE_PORTION_GLOBAL',
                'r.TOTAL_TVA',
                'r.VALIDATION',

                DB::raw('r.VALIDATION_DATE as Date_validation'),
                DB::raw('j.CREDIT as JCredit'),
                DB::raw('j.Rebate as JRemise'),
                DB::raw('IFNULL(SUM(rr.montant), 0) as Payed'),
                DB::raw('IFNULL(SUM(rr.rebate), 0) as PayedRebat'),
                DB::raw('r.INS_DATE as Date_Création'),

                'r.INS_USER',

                DB::raw('r.UPD_DATE as Date_Modification'),

                'r.UPD_USER',
                'r.EmployeeId',
                'r.DEPOT_ID',

                DB::raw('r.COMMANDE_ID as view_achat_credit_fournisseur'),
                DB::raw('r.DEPOT_NAME as Depot'),
                DB::raw('u.NOM as Utilisateur'),
            ])

            ->leftJoin(
                'achat_journal_fournisseur as j',
                'j.JOURNAL_FOURNISSEUR_ID',
                '=',
                'r.JOURNAL_ID'
            )

            ->leftJoin(
                'users as u',
                'u.USER_ID',
                '=',
                'r.EmployeeId'
            )

            ->leftJoin(
                'achat_reglement_reception as rr',
                function ($join) {
                    $join->on('r.RECEPTION_ID', '=', 'rr.reception_id')
                         ->where('rr.validate', '<>', 0);
                }
            )

            ->groupBy('r.RECEPTION_ID')

            ->get();
    }
    /*
    |--------------------------------------------------------------------------
    | VIEW_ACHAT_RECEPTION_4_PAIEMENT
    |--------------------------------------------------------------------------
    */

    public function getViewAchatReception4Paiement()
    {
        return AchatReception::query()

            ->from('achat_reception as r')

            ->select([
                'r.RECEPTION_ID as ID',
                'r.REFERENCE as Réf',
                'r.RECEPTION_DATE as Date',
                'r.REFERENCE_ORIGINE as Livraison',
                'r.DATE_ORIGINE as Date livraison',
                'r.REFERENCE_FACTURE as Facture',
                'r.DATE_FACTURE as Date facture',

                'f.FOURNISSEUR_CODE',

                DB::raw("CONCAT(f.NOM, IFNULL(f.NOM2, '')) as Fournisseur"),

                'r.MONTANT_TOTAL as Total_TTC',
                'r.MONTANT_TOTAL_REEL as Montant_réel',
                'r.TOTAL_HT as Total_HT',
                'r.TotalRemise as TotalRemise',
                'r.REMISE_GLOBAL',
                'r.REMISE_PORTION_GLOBAL',
                'r.CHARGE_GLOBAL',
                'r.CHARGE_PORTION_GLOBAL',
                'r.TOTAL_TVA',
                'r.VALIDATION',
                'r.VALIDATION_DATE',

                DB::raw('r.INS_DATE as Date_Création'),

                'r.INS_USER',

                DB::raw('r.UPD_DATE as Date_Modification'),

                'r.UPD_USER',
                'r.EmployeeId',
                'r.DEPOT_ID',
                'r.COMMANDE_ID as CommandeId',
                'r.FOURNISSEUR_ID',

                DB::raw('j.CREDIT as JCredit'),
                DB::raw('j.Rebate as JRemise'),
                DB::raw('j.RebatePortion as Remise_pourcentage'),

                // Sous-requête pour Payed
                DB::raw("
                    (SELECT IFNULL(SUM(IFNULL(rf.montant, 0)), 0)
                     FROM achat_reglement_reception as rf
                     WHERE rf.reception_id = r.RECEPTION_ID AND rf.validate = 1) as Payed
                "),

                // Sous-requête pour PayedRebat
                DB::raw("
                    (SELECT IFNULL(SUM(IFNULL(rf.rebate, 0)), 0)
                     FROM achat_reglement_reception as rf
                     WHERE rf.reception_id = r.RECEPTION_ID AND rf.validate = 1) as PayedRebat
                ")
            ])

            ->join(
                'achat_journal_fournisseur as j',
                'j.JOURNAL_FOURNISSEUR_ID',
                '=',
                'r.JOURNAL_ID'
            )

            ->join(
                'achat_fournisseur as f',
                'r.FOURNISSEUR_ID',
                '=',
                'f.FOURNISSEUR_ID'
            )

            ->get();
    }
    /*
    |--------------------------------------------------------------------------
    | VIEW_ACHAT_REGLEMENT_FOURNISSEUR
    |--------------------------------------------------------------------------
    */

    public function getViewAchatReglementFournisseur()
    {
        return AchatReglementFournisseur::query()

            ->from('achat_reglement_fournisseur as c')

            ->select([
                'c.REGLEMENT_ID',
                'c.FOURNISSEUR_ID',
                'c.JOURNAL_ID',
                'c.REFERENCE',
                'c.DESCRIPTION',
                'c.REGLEMENT_DATE',
                'c.MONTANT',
                'c.MODE_DE_PAIMENT_ID',
                'c.VALIDATION',
                'c.VALIDATION_DATE',
                'c.INS_USER',
                'c.INS_DATE',
                'c.UPD_USER',
                'c.UPD_DATE',
                'c.RECEPTION_REFERENCE',
                'c.ChequeNum',
                'c.ChequeEcheance',
                'c.reception_id',
                'c.Compte',
                'c.Holder',
                'c.banque_id',
                'c.cancled',
                'c.user_id',
                'c.FOURNISSEUR_CODE',

                DB::raw('c.FOURNISSEUR_NOM as Fournisseur'),
                DB::raw('u.NOM as Utilisateur'),
                DB::raw('m.MODE_PAIMANT as Mode_Paiement'),
                DB::raw('b.nom as Banque'),

                'c.status',
                'c.date_status',
                'c.date_valeur',
            ])

            ->leftJoin(
                'users as u',
                'c.user_id',
                '=',
                'u.USER_ID'
            )

            ->leftJoin(
                'modes_paiement as m',
                'c.MODE_DE_PAIMENT_ID',
                '=',
                'm.MODE_PAIMENT_ID'
            )

            ->leftJoin(
                'param_banque as b',
                'c.banque_id',
                '=',
                'b.id'
            )

            ->get();
    }
    /*
    |--------------------------------------------------------------------------
    | VIEW_RECEPTION_AVOIR
    |--------------------------------------------------------------------------
    */

    public function getViewReceptionAvoir()
    {
        // 1. Première sous-requête : Réceptions
        $receptions = DB::table('achat_reception as r')
            ->select([
                DB::raw("'Réception' AS Type"),
                'r.RECEPTION_ID AS BonId',
                'r.REFERENCE AS Réf',
                'r.RECEPTION_DATE AS Date',
                'r.REFERENCE_ORIGINE AS Livraison',
                'r.DATE_ORIGINE AS Date livraison',
                'r.REFERENCE_FACTURE AS Facture',
                'r.DATE_FACTURE AS Date facture',
                'r.MONTANT_TOTAL AS Total_TTC',
                'r.MONTANT_TOTAL_REEL AS Montant_réel',
                'r.TOTAL_HT AS Total_HT',
                'r.REMISE_GLOBAL AS REMISE_GLOBAL',
                'r.REMISE_PORTION_GLOBAL AS REMISE_PORTION_GLOBAL',
                'r.CHARGE_GLOBAL AS CHARGE_GLOBAL',
                'r.CHARGE_PORTION_GLOBAL AS CHARGE_PORTION_GLOBAL',
                'r.TOTAL_TVA AS TOTAL_TVA',
                'r.VALIDATION AS VALIDATION',
                'r.VALIDATION_DATE AS VALIDATION_DATE',
                'r.INS_DATE AS Date_Création',
                'r.INS_USER AS INS_USER',
                'r.UPD_DATE AS Date_Modification',
                'r.UPD_USER AS UPD_USER',
                'r.EmployeeId AS EmployeeId',
                'r.DEPOT_ID AS DEPOT_ID',
                'r.COMMANDE_ID AS OperationId',
                'r.FOURNISSEUR_ID AS FOURNISSEUR_ID'
            ]);

        // 2. Deuxième sous-requête : Avoirs
        $avoirs = DB::table('achat_avoir_fournisseur as a')
            ->select([
                DB::raw("'Avoir' AS Type"),
                'a.AVOIR_FOURNISSEUR_ID AS BonId',
                'a.REFERENCE AS Réf',
                'a.AVOIR_FOURNISSEUR_DATE AS Date',
                DB::raw('NULL AS Livraison'),
                DB::raw('NULL AS `Date livraison`'),
                DB::raw('NULL AS Facture'),
                DB::raw('NULL AS `Date facture`'),
                'a.MONTANT_TOTAL AS Total_TTC',
                DB::raw('0 AS Montant_réel'),
                DB::raw('0 AS Total_HT'),
                DB::raw('0 AS REMISE_GLOBAL'),
                DB::raw('0 AS REMISE_PORTION_GLOBAL'),
                DB::raw('0 AS CHARGE_GLOBAL'),
                DB::raw('0 AS CHARGE_PORTION_GLOBAL'),
                'a.TOTAL_TVA AS TOTAL_TVA',
                'a.VALIDATION AS VALIDATION',
                'a.VALIDATION_DATE AS VALIDATION_DATE',
                'a.INS_DATE AS Date_Création',
                'a.INS_USER AS INS_USER',
                'a.UPD_DATE AS Date_Modification',
                'a.UPD_USER AS UPD_USER',
                'a.USER_ID AS EmployeeId',
                'a.DEPOT_ID AS DEPOT_ID',
                DB::raw('NULL AS OperationId'),
                'a.FOURNISSEUR_ID AS FOURNISSEUR_ID'
            ]);

        // 3. Union ALL des deux structures de base
        $unionQuery = $receptions->unionAll($avoirs);

        // 4. Application des jointures finales sur l'ensemble fédéré
        return DB::table(DB::raw("({$unionQuery->toSql()}) as a"))
            ->mergeBindings($unionQuery)
            ->select([
                'a.Type',
                'a.BonId',
                'a.Réf',
                'a.Date',
                'a.Livraison',
                'a.Date livraison',
                'a.Facture',
                'a.Date facture',
                'a.Total_TTC',
                'a.Montant_réel',
                'a.Total_HT',
                'a.REMISE_GLOBAL',
                'a.REMISE_PORTION_GLOBAL',
                'a.CHARGE_GLOBAL',
                'a.CHARGE_PORTION_GLOBAL',
                'a.TOTAL_TVA',
                'a.VALIDATION',
                'a.VALIDATION_DATE',
                'a.Date_Création',
                'a.INS_USER',
                'a.Date_Modification',
                'a.UPD_USER',
                'a.EmployeeId',
                'a.DEPOT_ID',
                'a.OperationId',
                'a.FOURNISSEUR_ID',
                'f.FOURNISSEUR_CODE',
                DB::raw("CONCAT(f.NOM, IFNULL(f.NOM2, '')) AS Fournisseur"),
                'd.DEPOT_LIBELE AS Dépot',
                'u.NOM AS Utilisateur'
            ])
            ->join('achat_fournisseur as f', 'f.FOURNISSEUR_ID', '=', 'a.FOURNISSEUR_ID')
            ->join('stock_depot as d', 'd.DEPOT_ID', '=', 'a.DEPOT_ID')
            ->leftJoin('users as u', 'u.USER_ID', '=', 'a.EmployeeId')
            ->get();
    }

}
