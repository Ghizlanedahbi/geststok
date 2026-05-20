<?php

namespace App\Services;

use App\Models\AchatAvoirFournisseur;
use App\Models\AchatCreditFournisseur;
use App\Models\AchatFournisseur;
use App\Models\AchatJournalFournisseur;
use App\Models\AchatReception;
use App\Models\AchatReglementFournisseur;
use Illuminate\Support\Facades\DB;
use Exception;

class AchatService
{
    public function getAvoirFournisseur($perPage = 15)
    {
        try {
            return AchatAvoirFournisseur::query()
                ->from('achat_avoir_fournisseur as a')
                ->select([
                    'a.AVOIR_FOURNISSEUR_ID', 'a.RECEPTION_ID', 'a.REFERENCE', 'a.AVOIR_FOURNISSEUR_DATE',
                    'a.FOURNISSEUR_ID', 'a.TOTAL_HT', 'a.MONTANT_TOTAL', 'a.TOTAL_TVA', 'a.VALIDATION',
                    'a.VALIDATION_DATE', 'a.INS_DATE', 'a.INS_USER', 'a.UPD_DATE', 'a.UPD_USER',
                    'a.USER_ID', 'a.DEPOT_ID',
                    DB::raw('IFNULL(SUM(c.MONTANT),0) AS Payed'),
                    'j.DEBIT as JDebut', 'j.CREDIT as JCredit', 'j.JOURNAL_ID',
                    'f.FOURNISSEUR_CODE', 'f.NOM as Fournisseur', 'd.DEPOT_LIBELE as Depot'
                ])
                ->leftJoin('achat_reglement_fournisseur as c', 'c.AVOIR_FOURNISSEUR_ID', '=', 'a.AVOIR_FOURNISSEUR_ID')
                ->leftJoin('achat_journal_fournisseur as j', function ($join) {
                    $join->on('j.OPERATION_ID', '=', 'a.AVOIR_FOURNISSEUR_ID')->where('j.TYPE', '=', 'AV');
                })
                ->join('achat_fournisseur as f', 'f.FOURNISSEUR_ID', '=', 'a.FOURNISSEUR_ID')
                ->join('stock_depot as d', 'd.DEPOT_ID', '=', 'a.DEPOT_ID')
                ->groupBy([
                    'a.AVOIR_FOURNISSEUR_ID', 'a.RECEPTION_ID', 'a.REFERENCE', 'a.AVOIR_FOURNISSEUR_DATE',
                    'a.FOURNISSEUR_ID', 'a.TOTAL_HT', 'a.MONTANT_TOTAL', 'a.TOTAL_TVA', 'a.VALIDATION',
                    'a.VALIDATION_DATE', 'a.INS_DATE', 'a.INS_USER', 'a.UPD_DATE', 'a.UPD_USER',
                    'a.USER_ID', 'a.DEPOT_ID', 'j.DEBIT', 'j.CREDIT', 'j.JOURNAL_ID',
                    'f.FOURNISSEUR_CODE', 'f.NOM', 'd.DEPOT_LIBELE'
                ])
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des avoirs fournisseurs.");
        }
    }

    public function getViewFournisseurs($perPage = 15)
    {
        try {
            return AchatFournisseur::query()
                ->select(['FOURNISSEUR_ID', 'FOURNISSEUR_CODE', 'NOM', 'TEL', 'MAIL', 'ADRESSE', 'VILLE'])
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de la liste des fournisseurs.");
        }
    }

    public function getViewJournalFournisseur($perPage = 15)
    {
        try {
            return AchatJournalFournisseur::query()
                ->select(['JOURNAL_ID', 'FOURNISSEUR_ID', 'DATE_LOG', 'OPERATION', 'DEBIT', 'CREDIT', 'REMARQUE'])
                ->orderBy('DATE_LOG', 'desc')
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du journal fournisseur.");
        }
    }

    public function getViewAchatReception($perPage = 15)
    {
        try {
            return AchatReception::query()
                ->select(['RECEPTION_ID', 'REFERENCE', 'RECEPTION_DATE', 'TOTAL_TTC', 'VALIDATION'])
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des réceptions d'achat.");
        }
    }

    public function getViewAchatReception4Paiement($perPage = 15)
    {
        try {
            return AchatReception::query()
                ->where('VALIDATION', 1)
                ->select(['RECEPTION_ID', 'REFERENCE', 'RECEPTION_DATE', 'TOTAL_TTC'])
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des réceptions pour paiement.");
        }
    }

    public function getViewAchatReglementFournisseur($perPage = 15)
    {
        try {
            return AchatReglementFournisseur::query()
                ->select(['REGLEMENT_ID', 'REFERENCE', 'REGLEMENT_DATE', 'MONTANT', 'MODE_PAIEMENT'])
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des règlements.");
        }
    }

    public function getViewArticleAnalysis($perPage = 15)
    {
        try {
            return DB::table('view_articleanalysis')
                ->select(['PRODUIT_ID', 'DESIGNATION', 'QUANTITE_ACHETEE', 'MONTANT_TOTAL'])
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'analyse des articles.");
        }
    }

    public function getViewReceptionAvoir($perPage = 15)
    {
        try {
            return DB::table('view_sales_lines')
                ->select(['ID', 'LIVRAISON_ID', 'REFERENCE', 'DESIGNATION', 'TOTAL'])
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des lignes de réception d'avoirs.");
        }
    }

    public function getViewAchatOperation($perPage = 15)
    {
        try {
            $unionQuery = $this->getAchatUnionBuilder();

            return DB::table(DB::raw("({$unionQuery->toSql()}) as a"))
                ->mergeBindings($unionQuery)
                ->select([
                    'a.Type', 'a.BonId', 'a.Réf', 'a.Date', 'a.Total_TTC', 'a.VALIDATION',
                    'f.FOURNISSEUR_CODE', DB::raw("CONCAT(f.NOM, IFNULL(f.NOM2, '')) AS Fournisseur"),
                    'd.DEPOT_LIBELE AS Dépot', 'u.NOM AS Utilisateur'
                ])
                ->join('achat_fournisseur as f', 'f.FOURNISSEUR_ID', '=', 'a.FOURNISSEUR_ID')
                ->join('stock_depot as d', 'd.DEPOT_ID', '=', 'a.DEPOT_ID')
                ->join('users as u', 'u.USER_ID', '=', 'a.EmployeeId')
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des opérations d'achat unifiées.");
        }
    }

    /**
     * Helper pour centraliser la sous-requête de l'Union des opérations d'achat
     */
    protected function getAchatUnionBuilder()
    {
        $receptions = DB::table('achat_reception as r')
            ->select([
                DB::raw("'BR' as Type"), 'r.RECEPTION_ID as BonId', 'r.REFERENCE as Réf', 'r.RECEPTION_DATE as Date',
                'r.TOTAL_TTC', 'r.VALIDATION', 'r.FOURNISSEUR_ID', 'r.DEPOT_ID', 'r.USER_ID as EmployeeId'
            ]);

        $avoirs = DB::table('achat_avoir_fournisseur as av')
            ->select([
                DB::raw("'AV' as Type"), 'av.AVOIR_FOURNISSEUR_ID as BonId', 'av.REFERENCE as Réf', 'av.AVOIR_FOURNISSEUR_DATE as Date',
                DB::raw('-av.MONTANT_TOTAL as TOTAL_TTC'), 'av.VALIDATION', 'av.FOURNISSEUR_ID', 'av.DEPOT_ID', 'av.USER_ID as EmployeeId'
            ]);

        return $receptions->unionAll($avoirs);
    }
}