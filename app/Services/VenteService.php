<?php

namespace App\Services;

use App\Models\VenteAvoir;
use App\Models\VenteClient;
use App\Models\VenteCreditBonAchat;
use App\Models\VenteCreditClient;
use App\Models\VenteFacture;
use App\Models\VenteJClient;
use App\Models\VenteLivraison;
use App\Models\VenteLivraisonLigne;
use App\Models\VenteOrderOutput;
use App\Models\VenteOrderOutputLigne;
use App\Models\VenteReglementsClient;
use App\Models\VenteReglementLivraison;
use App\Models\VenteAvoirLigne;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VenteService
{
    /*
    |--------------------------------------------------------------------------
    | 1. VIEW_VENTE
    |--------------------------------------------------------------------------
    */
    public function getViewVente(int $perPage = 15): LengthAwarePaginator
    {
        $avoirs = VenteAvoir::query()
            ->from('vente_avoir')
            ->select([
                DB::raw("'AV' as Type"),
                'vente_avoir.AVROIR_ID',
                'vente_avoir.REFERENCE',
                'vente_avoir.AVOIR_DATE',
                'vente_avoir.CLIENT_ID',
                'vente_avoir.TTVA',
                'vente_avoir.MONTANT_TOTAL',
                'vente_avoir.PAYED',
                'vente_avoir.TOTAL_REMISE',
                'vente_avoir.TOTAL_LETTRES',
                'vente_avoir.TOTAL_TVA',
                'vente_avoir.JOURNAL_ID',
                'vente_avoir.INS_USER',
                'vente_avoir.INS_DATE',
                'vente_avoir.UPD_USER',
                'vente_avoir.UPD_DATE',
                'vente_avoir.VALIDATION',
                'vente_avoir.VALIDATION_DATE',
                'vente_avoir.DEPOT_ID',
                'vente_avoir.employee_id',
                'vente_avoir.TotalMargin',
            ]);

        return VenteLivraison::query()
            ->from('vente_livraison as v')
            ->select([
                DB::raw("'BL' as Type"),
                'v.LIVRAISON_ID as AVROIR_ID',
                'v.REFERENCE',
                'v.LIVRAISON_DATE as AVOIR_DATE',
                'v.CLIENT_ID',
                'v.TTVA',
                'v.MONTANT_TOTAL',
                'v.PAYED',
                'v.TotalRemise as TOTAL_REMISE',
                'v.TOTAL_LETTRES',
                'v.TOTAL_TVA',
                'v.JOURNAL_ID',
                'v.INS_USER',
                'v.INS_DATE',
                'v.UPD_USER',
                'v.UPD_DATE',
                'v.VALIDATION',
                'v.VALIDATION_DATE',
                'v.DEPOT_ID',
                'v.EmployeeId as employee_id',
                'v.TatalMargin as TotalMargin',
            ])
            ->unionAll($avoirs)
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 2. VIEW_VENTE_AVOIR
    |--------------------------------------------------------------------------
    */
    public function getViewVenteAvoir(int $perPage = 15): LengthAwarePaginator
    {
        return VenteAvoir::query()
            ->from('vente_avoir as v')
            ->select([
                'v.AVROIR_ID',
                DB::raw('v.REFERENCE as `Réf avoir`'),
                DB::raw('v.AVOIR_DATE as Date_avoir'),
                'v.CLIENT_ID',
                'v.TTVA',
                'v.TOTAL_HT',
                'v.MONTANT_TOTAL',
                'v.TOTAL_REMISE',
                'v.TOTAL_LETTRES',
                'v.TOTAL_TVA',
                DB::raw('v.JOURNAL_ID as Journal'),
                'v.INS_USER',
                DB::raw('v.INS_DATE as Date_création'),
                'v.UPD_USER',
                DB::raw('v.UPD_DATE as Date_modification'),
                'v.VALIDATION',
                DB::raw('v.VALIDATION_DATE as Date_validation'),
                'v.DEPOT_ID',
                'v.employee_id',
                'v.TotalMargin',
                'v.TauxMargin',
                DB::raw('j.CREDIT as JCredit'),
                DB::raw('IFNULL(SUM(c.MONTANT), 0) as Payed'),
                DB::raw('u.NOM as Employee'),
                DB::raw('d.DEPOT_LIBELE as Dépot'),
                DB::raw('v.CLIENT_CODE as Code_client'),
                DB::raw('v.CLIENT_NAME as Client'),
            ])
            ->leftJoin('vente_credit_client as c', function ($join) {
                $join->on('v.AVROIR_ID', '=', 'c.AvoirId')
                     ->where('v.VALIDATION', '<>', 0)
                     ->where('c.VALIDATION', '<>', 0);
            })
            ->leftJoin('vente_jclient as j', 'v.JOURNAL_ID', '=', 'j.JOURNAL_CLIENT_ID')
            ->join('stock_depot as d', 'd.DEPOT_ID', '=', 'v.DEPOT_ID')
            ->leftJoin('users as u', 'u.USER_ID', '=', 'v.employee_id')
            ->groupBy([
                'v.AVROIR_ID', 'v.REFERENCE', 'v.AVOIR_DATE', 'v.CLIENT_ID', 'v.TTVA',
                'v.TOTAL_HT', 'v.MONTANT_TOTAL', 'v.TOTAL_REMISE', 'v.TOTAL_LETTRES',
                'v.TOTAL_TVA', 'v.JOURNAL_ID', 'v.INS_USER', 'v.INS_DATE', 'v.UPD_USER',
                'v.UPD_DATE', 'v.VALIDATION', 'v.VALIDATION_DATE', 'v.DEPOT_ID',
                'v.employee_id', 'v.TotalMargin', 'v.TauxMargin', 'j.CREDIT',
                'u.NOM', 'd.DEPOT_LIBELE', 'v.CLIENT_CODE', 'v.CLIENT_NAME'
            ])
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 3. VIEW_VENTE_AVOIROLD
    |--------------------------------------------------------------------------
    */
    public function getViewVenteAvoirOld(int $perPage = 15): LengthAwarePaginator
    {
        return VenteAvoir::query()
            ->from('vente_avoir as a')
            ->select([
                'a.AVROIR_ID',
                'a.REFERENCE',
                'a.AVOIR_DATE',
                DB::raw('c.CLIENT_CODE as Code_client'),
                DB::raw('c.NOM as Client'),
                'a.CLIENT_ID',
                'a.TTVA',
                'a.MONTANT_TOTAL',
                'a.PAYED',
                'a.TOTAL_REMISE',
                'a.TOTAL_LETTRES',
                'a.TOTAL_TVA',
                'a.JOURNAL_ID',
                'a.INS_USER',
                DB::raw('a.INS_DATE as Date_création'),
                'a.UPD_USER',
                DB::raw('a.UPD_DATE as Date_modification'),
                'a.VALIDATION',
                DB::raw('a.VALIDATION_DATE as Date_validation'),
                'a.DEPOT_ID',
                DB::raw('d.DEPOT_LIBELE as Dépot'),
                DB::raw('a.employee_id as USER_ID'),
                DB::raw('u.NOM as Employee'),
                'a.TotalMargin',
            ])
            ->join('vente_client as c', 'a.CLIENT_ID', '=', 'c.CLIENT_ID')
            ->join('stock_depot as d', 'd.DEPOT_ID', '=', 'a.DEPOT_ID')
            ->leftJoin('users as u', 'u.USER_ID', '=', 'a.employee_id')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 4. VIEW_VENTE_CLIENT
    |--------------------------------------------------------------------------
    */
    public function getViewVenteClient(int $perPage = 15): LengthAwarePaginator
    {
        return VenteClient::query()
            ->from('vente_client as c')
            ->select([
                'c.CLIENT_ID', 'c.CLIENT_CODE', 'c.NOM', 'c.NOM2', 'c.ADRESSE', 'c.VILLE',
                'c.TEL', 'c.GSM', 'c.FAXE', 'c.CONTACT', 'c.MAIL', 'c.LOGO', 'c.IF',
                'c.PATENTE', 'c.RC', 'c.CNSS', 'c.SEUIL_CREDIT', 'c.OLD_CREDIT',
                'c.CLIENT_CATEGORIE_ID', 'c.INS_USER', 'c.INS_DATE', 'c.UPD_USER',
                'c.UPD_DATE', 'c.DEFAUT', 'c.ACTIF', 'c.ICE', 'c.VendorId', 'c.IS_CONFRERE',
                DB::raw('ct.CLIENT_CATEGORIE_LIBELE as CLIENT_CATEGORIE_LIBELE'),
            ])
            ->leftJoin('vente_client_categorie as ct', 'c.CLIENT_CATEGORIE_ID', '=', 'ct.CLIENT_CATEGORIE_ID')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 5. VIEW_VENTE_CREDIT_BON_ACHAT
    |--------------------------------------------------------------------------
    */
    public function getViewVenteCreditBonAchat(int $perPage = 15): LengthAwarePaginator
    {
        return VenteCreditBonAchat::query()
            ->from('vente_credit_bon_achat as b')
            ->select([
                DB::raw('c.CLIENT_CODE as CLIENT_CODE'),
                DB::raw('c.NOM as Client'),
                DB::raw('u.NOM as USER'),
                'b.ID', 'b.CLIENT_ID', 'b.USER_ID', 'b.REFERENCE', 'b.DESCRIPTION',
                'b.REGLEMENT_DATE', 'b.MONTANT', 'b.VALIDATION', 'b.VALIDATION_DATE',
                'b.EXPERATION_DATE', 'b.RESTE', 'b.INS_USER', 'b.INS_DATE', 'b.UPD_USER', 'b.UPD_DATE'
            ])
            ->join('users as u', 'u.USER_ID', '=', 'b.USER_ID')
            ->join('vente_client as c', 'c.CLIENT_ID', '=', 'b.CLIENT_ID')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 6. VIEW_VENTE_CREDIT_CLIENT
    |--------------------------------------------------------------------------
    */
    public function getViewVenteCreditClient(int $perPage = 15): LengthAwarePaginator
    {
        return VenteCreditClient::query()
            ->from('vente_credit_client as r')
            ->select([
                DB::raw('r.CREDIT_ID as `Crédit N°`'),
                'r.REFERENCE',
                DB::raw('r.REFERENCE_OPERATION as `Ref Operation`'),
                DB::raw('r.CREDIT_DATE as Date'),
                'r.user_id', 'r.CLIENT_ID',
                DB::raw('r.VALIDATION_DATE as Date_validation'),
                'r.MONTANT', 'r.JOURNAL_ID', 'r.AvoirId',
                DB::raw('r.Holder as Propriétaire'),
                DB::raw('r.mode_paeiment as MODE_DE_PAIMENT_ID'),
                DB::raw('c.CLIENT_CODE as Code_client'),
                DB::raw('c.NOM as Client'),
                DB::raw('p.MODE_PAIMANT as MODE_PAIMANT'),
                'r.PaiementEcheance', 'r.DESCRIPTION', 'r.PaiementNo',
                DB::raw('b.nom as Banque'),
                DB::raw('u.NOM as Employee'),
                'r.is_credit', 'r.type',
            ])
            ->leftJoin('vente_client as c', 'r.CLIENT_ID', '=', 'c.CLIENT_ID')
            ->leftJoin('modes_paiement as p', 'r.mode_paeiment', '=', 'p.MODE_PAIMENT_ID')
            ->leftJoin('param_banque as b', 'r.bank_id', '=', 'b.id')
            ->leftJoin('users as u', 'r.user_id', '=', 'u.USER_ID')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 7. VIEW_VENTE_FACTURE
    |--------------------------------------------------------------------------
    */
    public function getViewVenteFacture(int $perPage = 15): LengthAwarePaginator
    {
        return VenteFacture::query()
            ->from('vente_facture as f')
            ->select([
                'f.FACTURE_ID', 'f.REFERENCE', 'f.FACTURE_DATE', 'f.CLIENT_ID', 'f.CLIENT_CODE',
                DB::raw('CASE WHEN f.CLIENT_ORIGINE IS NULL THEN f.CLIENT_NOM ELSE f.CLIENT_ORIGINE END as CLIENT'),
                'f.TTVA', 'f.MONTANT_TOTAL', 'f.TOTAL_LETTRES', 'f.DISIGNATION', 'f.TOTAL_TVA',
                'f.TotalRemise', 'f.JOURNAL_ID', 'f.INS_USER', 'f.INS_DATE', 'f.UPD_USER', 'f.UPD_DATE',
                'f.VALIDATION', 'f.VALIDATION_DATE', 'f.MODE_PAIMENT_ID', 'f.ECHEANCE',
                'f.CONDITIONS_REGLEMENT_ID', 'f.CLIENT_NOM', 'f.CLIENT_ADRESS', 'f.CHEQUE_NUM',
                'f.ModePaiementText',
                DB::raw('m.MODE_PAIMANT as MODE_PAIMANT'),
                'f.CLIENT_PHONE',
                DB::raw('f.LIVRAISON_ID as Livraison_Id'),
                'f.AlreadyDelevred', 'f.Type',
            ])
            ->leftJoin('modes_paiement as m', 'm.MODE_PAIMENT_ID', '=', 'f.MODE_PAIMENT_ID')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 8. VIEW_VENTE_JCLIENT
    |--------------------------------------------------------------------------
    */
    public function getViewVenteJClient(int $perPage = 15): LengthAwarePaginator
    {
        return VenteJClient::query()
            ->from('vente_jclient as j')
            ->select([
                'j.JOURNAL_CLIENT_ID', 'j.CLIENT_ID', 'j.REFERENCE', 'j.JOURNAL_CLIENT_DATE',
                'j.DESCRIPTION', 'j.DEBUT', 'j.CREDIT', 'j.INS_USER', 'j.INS_DATE', 'j.UPD_USER',
                'j.UPD_DATE', 'j.LIVRAISON_REFERENCE', 'j.VendorId', 'j.Rebat', 'j.RebatePortion',
                'j.mode_paiement_id', 'j.type', 'j.cancled', 'j.mode_paiementText', 'j.lock_out',
                'j.lock_out_date', 'j.user_id', 'j.date_echiance', 'j.operation',
                DB::raw('c.CLIENT_CODE as Code_client'),
                DB::raw('c.NOM as Client'),
                DB::raw('m.MODE_PAIMANT as Mode_Paiement'),
                DB::raw('b.nom as nom'),
                DB::raw('u.LOGIN as LOGIN'),
                DB::raw('c.TEL as TEL'),
            ])
            ->join('vente_client as c', 'c.CLIENT_ID', '=', 'j.CLIENT_ID')
            ->leftJoin('modes_paiement as m', 'm.MODE_PAIMENT_ID', '=', 'j.mode_paiement_id')
            ->leftJoin('users as u', 'j.user_id', '=', 'u.USER_ID')
            ->leftJoin('param_banque as b', 'b.id', '=', 'j.bank_id')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 9. VIEW_VENTE_LIVRAISON
    |--------------------------------------------------------------------------
    */
    public function getViewVenteLivraison(int $perPage = 15): LengthAwarePaginator
    {
        return VenteLivraison::query()
            ->from('vente_livraison as v')
            ->select([
                DB::raw('v.LIVRAISON_ID as `N°`'),
                DB::raw('v.REFERENCE as `Réf`'),
                DB::raw('v.LIVRAISON_DATE as Date_livraison'),
                DB::raw('f.REFERENCE as Facture'),
                DB::raw('v.CLIENT_CODE as Code_Client'),
                DB::raw('v.CLIENT_NOM as Client'),
                DB::raw('v.TotalHT as Total_HT'),
                DB::raw('v.MONTANT_TOTAL as Total_TTC'),
                DB::raw('IFNULL(SUM(r.montant), 0) as Payed'),
                DB::raw('IFNULL(SUM(r.rebate), 0) as PayedRebat'),
                DB::raw('j.DEBUT as JDebut'),
                DB::raw('j.Rebat as JRemise'),
                DB::raw('v.TotalRemise as Total_remise'),
                DB::raw('v.TOTAL_TVA as Total_TVA'),
                DB::raw('v.TatalMargin as Tatal_Marge'),
                DB::raw('v.ECHEANCE as `Echéance`'),
                DB::raw('v.VALIDATION as Validation'),
                DB::raw('v.VALIDATION_DATE as Date_validation'),
                DB::raw('v.INS_DATE as Date_création'),
                DB::raw('v.UPD_DATE as Date_modification'),
                DB::raw('v.DEPOT_NAME as `Dépot`'),
                DB::raw('u.NOM as Utilisateur'),
                'v.CLIENT_ID', 'v.EmployeeId', 'v.FactureId',
                DB::raw('f.VALIDATION as Factured'),
                DB::raw('v.TauxMargin as ttaux_marge'),
                'v.AVOIR_COMPLET_REF', 'v.Type',
            ])
            ->leftJoin('users as u', 'v.EmployeeId', '=', 'u.USER_ID')
            ->leftJoin('vente_reglement_livraison as r', function ($join) {
                $join->on('v.LIVRAISON_ID', '=', 'r.livraison_id')
                     ->where('r.validate', '<>', 0);
            })
            ->leftJoin('vente_jclient as j', 'j.JOURNAL_CLIENT_ID', '=', 'v.JOURNAL_ID')
            ->leftJoin('vente_facture as f', function ($join) {
                $join->on('v.FactureId', '=', 'f.FACTURE_ID')
                     ->where('f.VALIDATION', '=', 1);
            })
            ->groupBy([
                'v.LIVRAISON_ID', 'v.REFERENCE', 'v.LIVRAISON_DATE', 'v.CLIENT_CODE', 'v.CLIENT_NOM',
                'v.TotalHT', 'v.MONTANT_TOTAL', 'v.PAYED', 'v.TotalRemise', 'v.TOTAL_TVA', 'v.ECHEANCE',
                'v.VALIDATION', 'v.VALIDATION_DATE', 'v.INS_DATE', 'v.UPD_DATE', 'v.DEPOT_NAME',
                'u.NOM', 'v.CLIENT_ID', 'v.EmployeeId', 'v.FactureId', 'f.VALIDATION', 'v.TauxMargin',
                'v.AVOIR_COMPLET_REF', 'v.Type', 'f.REFERENCE', 'j.DEBUT', 'j.Rebat'
            ])
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 10. VIEW_VENTE_LIVRAISON2
    |--------------------------------------------------------------------------
    */
    public function getViewVenteLivraison2(int $perPage = 15): LengthAwarePaginator
    {
        return VenteLivraison::query()
            ->from('vente_livraison as v')
            ->select([
                DB::raw('v.LIVRAISON_ID as `N°`'),
                DB::raw('v.REFERENCE as `Réf`'),
                DB::raw('v.LIVRAISON_DATE as Date_livraison'),
                DB::raw('c.CLIENT_CODE as Code_Client'),
                DB::raw('c.NOM as Client'),
                DB::raw('v.TotalHT as Total_HT'),
                DB::raw('v.MONTANT_TOTAL as Total_TTC'),
                DB::raw('v.PAYED as `Payé`'),
                DB::raw('v.TotalRemise as Total_remise'),
                DB::raw('v.TOTAL_TVA as Total_TVA'),
                DB::raw('v.ECHEANCE as `Echéance`'),
                DB::raw('v.VALIDATION as Validation'),
                DB::raw('v.VALIDATION_DATE as Date_validation'),
                DB::raw('v.INS_DATE as Date_création'),
                DB::raw('v.UPD_DATE as Date_modification'),
                DB::raw('d.DEPOT_LIBELE as `Dépot`'),
                DB::raw('u.NOM as Utilisateur'),
                'v.CLIENT_ID', 'v.EmployeeId', 'v.FactureId',
            ])
            ->join('vente_client as c', 'v.CLIENT_ID', '=', 'c.CLIENT_ID')
            ->join('stock_depot as d', 'v.DEPOT_ID', '=', 'd.DEPOT_ID')
            ->join('users as u', 'v.EmployeeId', '=', 'u.USER_ID')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 11. VIEW_VENTE_LIVRAISON_LIGNE
    |--------------------------------------------------------------------------
    */
    public function getViewVenteLivraisonLigne(int $perPage = 15): LengthAwarePaginator
    {
        return VenteLivraisonLigne::query()
            ->from('vente_livraison_ligne as l')
            ->select([
                DB::raw('lv.REFERENCE as REFERENCE'),
                'l.ID', 'l.LIVRAISON_ID', 'l.PRODUIT_ID', 'l.PRODUIT_REFERENCE', 'l.DESIGNATION',
                'l.UNITE_ID', 'l.QUANTITE', 'l.QUANTITE2', 'l.PRIX_UNITAIRE', 'l.TAUX_TVA',
                'l.REMISE', 'l.REMISE_AMOUNT', 'l.Total', 'l.INS_USER', 'l.INS_DATE', 'l.UPD_USER',
                'l.UPD_DATE', 'l.NOM1', 'l.NOM2', 'l.NOM3', 'l.PRODUCT_PROPERTY', 'l.DATE_EXPIRY',
                'l.PRIX_ACHAT', 'l.Margin', 'l.ShopPriceAvg', 'l.POID', 'l.Inventory', 'l.OrderId',
                'l.FREE_QUANTITY', 'l.OUTPUT_ID', 'l.Color',
            ])
            ->join('vente_livraison as lv', 'lv.LIVRAISON_ID', '=', 'l.LIVRAISON_ID')
            ->where(function ($query) {
                $query->whereNull('l.OUTPUT_ID')
                      ->orWhereExists(function ($subQuery) {
                          $subQuery->select(DB::raw(1))
                                   ->from('vente_order_output as o')
                                   ->where('o.VALIDATION', 1)
                                   ->whereColumn('o.LIVRAISON_ID', 'l.LIVRAISON_ID');
                      });
            })
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 12. VIEW_VENTE_ORDER_OUTPUT
    |--------------------------------------------------------------------------
    */
    public function getViewVenteOrderOutput(int $perPage = 15): LengthAwarePaginator
    {
        return VenteOrderOutput::query()
            ->from('vente_order_output as o')
            ->select([
                'o.ID', 'o.REFERENCE',
                DB::raw('l.REFERENCE as `Réf_livraison`'),
                'o.LIVRAISON_ID', 'o.LIVRAISON_DATE', 'o.REFERENCE_ORIGINE', 'o.CLIENT_ID',
                'o.TTVA', 'o.MONTANT_TOTAL', 'o.Total_HT', 'o.TOTAL_LETTRES', 'o.TOTAL_TVA',
                'o.JOURNAL_ID', 'o.DEPOT_ID', 'o.INS_USER', 'o.INS_DATE', 'o.UPD_USER', 'o.UPD_DATE',
                'o.VALIDATION', 'o.VALIDATION_DATE', 'o.ECHEANCE', 'o.METHODE_LIVRAISON_ID',
                'o.CONDITIONS_REGLEMENT_ID', 'o.EmployeeId', 'o.TatalMargin', 'o.TauxMargin',
                'o.FactureId', 'o.Avance', 'o.Commande_Id', 'o.STATUE', 'o.IS_CASH', 'o.DELEVERED',
                'o.TotalRemise',
                DB::raw('d.DEPOT_LIBELE as `Dépot`'),
                DB::raw('o.CLIENT_CODE as Code_client'),
                DB::raw('o.CLIENT_NAME as Client'),
                DB::raw('u.NOM as `Employé`'),
                DB::raw('l.VALIDATION as `Livré`'),
            ])
            ->join('stock_depot as d', 'd.DEPOT_ID', '=', 'o.DEPOT_ID')
            ->join('users as u', 'u.USER_ID', '=', 'o.EmployeeId')
            ->leftJoin('vente_livraison as l', function ($join) {
                $join->on('l.LIVRAISON_ID', '=', 'o.LIVRAISON_ID')
                     ->where('l.VALIDATION', '<>', 0);
            })
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 13. VIEW_VENTE_ORDER_OUTPUT_ALL
    |--------------------------------------------------------------------------
    */
    public function getViewVenteOrderOutputAll(int $perPage = 15): LengthAwarePaginator
    {
        return VenteOrderOutputLigne::query()
            ->from('vente_order_output_ligne as ol')
            ->select([
                DB::raw('o.REFERENCE as RefSorie'),
                'ol.ID',
                DB::raw('o.CLIENT_CODE as `Code Client`'),
                DB::raw('o.CLIENT_NAME as Client'),
                'ol.OUTPUT_ID', 'ol.LIVRAISON_ID', 'ol.PRODUIT_ID', 'ol.PRODUIT_REFERENCE',
                'ol.DESIGNATION', 'ol.UNITE_ID', 'ol.QUANTITE', 'ol.PRIX_UNITAIRE', 'ol.TAUX_TVA',
                'ol.REMISE', 'ol.NOM1', 'ol.NOM2', 'ol.NOM3', 'ol.DATE_EXPIRY', 'ol.FREE_QUANTITY',
                'ol.PRIX_ACHAT',
                DB::raw('o.ID as outPutId'),
                'o.REFERENCE', 'o.LIVRAISON_DATE', 'o.VALIDATION_DATE', 'o.VALIDATION',
                'o.CLIENT_ID', 'o.MONTANT_TOTAL', 'o.TotalRemise', 'o.DELEVERED',
            ])
            ->join('vente_order_output as o', 'ol.OUTPUT_ID', '=', 'o.ID')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 14. VIEW_VENTE_ORDER_OUTPUT_NONE_DELIVERED
    |--------------------------------------------------------------------------
    */
    public function getViewVenteOrderOutputNoneDelivered(int $perPage = 15): LengthAwarePaginator
    {
        return VenteOrderOutputLigne::query()
            ->from('vente_order_output_ligne as ol')
            ->select([
                DB::raw('o.REFERENCE as RefSorie'),
                'ol.ID', 'ol.OUTPUT_ID', 'ol.LIVRAISON_ID', 'ol.PRODUIT_ID', 'ol.PRODUIT_REFERENCE',
                'ol.DESIGNATION', 'ol.UNITE_ID', 'ol.QUANTITE', 'ol.PRIX_UNITAIRE', 'ol.TAUX_TVA',
                'ol.REMISE', 'ol.NOM1', 'ol.NOM2', 'ol.NOM3', 'ol.DATE_EXPIRY', 'ol.FREE_QUANTITY',
                'ol.PRIX_ACHAT',
                DB::raw('o.ID as outPutId'),
                'o.REFERENCE', 'o.LIVRAISON_DATE', 'o.VALIDATION_DATE', 'o.VALIDATION',
                'o.CLIENT_ID', 'o.MONTANT_TOTAL', 'o.TotalRemise', 'o.DELEVERED',
            ])
            ->join('vente_order_output as o', 'ol.OUTPUT_ID', '=', 'o.ID')
            ->whereNull('o.LIVRAISON_ID')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 15. VIEW_VENTE_REGLEMENTS_CLIENT
    |--------------------------------------------------------------------------
    */
    public function getViewVenteReglementsClient(int $perPage = 15): LengthAwarePaginator
    {
        return VenteReglementsClient::query()
            ->from('vente_reglements_client as r')
            ->select([
                DB::raw('r.REGLEMENT_ID as `Reglement N°`'),
                DB::raw('r.REFERENCE as `Référence`'),
                'r.user_id',
                DB::raw('r.LIVRAISON_REFERENCE as `Ref livraison`'),
                DB::raw('r.REGLEMENT_DATE as Date'),
                'r.CLIENT_ID',
                DB::raw('r.CLIENT_CODE as Code_client'),
                DB::raw('r.CLIENT_NOM as Client'),
                DB::raw('r.MONTANT as Montant'),
                DB::raw('r.VALIDATION as Validation'),
                DB::raw('r.VALIDATION_DATE as Date_validation'),
                DB::raw('r.Rebate as Remise'),
                DB::raw('r.RebatePortion as `Remise_%`'),
                'r.MODE_DE_PAIMENT_ID',
                DB::raw('p.MODE_PAIMANT as Mode_paiement'),
                'r.banque_id',
                DB::raw('b.nom as Banque'),
                DB::raw('r.ChequeNum as `Numéro`'),
                DB::raw('r.Holder as `Propriétaire`'),
                DB::raw('r.ChequeEcheance as `Echéance`'),
                'r.status', 'r.date_status', 'r.date_valeur',
            ])
            ->join('modes_paiement as p', 'r.MODE_DE_PAIMENT_ID', '=', 'p.MODE_PAIMENT_ID')
            ->leftJoin('users as u', 'r.user_id', '=', 'u.USER_ID')
            ->leftJoin('param_banque as b', 'r.banque_id', '=', 'b.id')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 16. VIEW_VENTE_VALIDE_REGLEMENT_LIVRAISON
    |--------------------------------------------------------------------------
    */
    public function getViewVenteValideReglementLivraison(int $perPage = 15): LengthAwarePaginator
    {
        return VenteReglementLivraison::query()
            ->from('vente_reglement_livraison as l')
            ->select([
                'l.livraison_id',
                'l.reglement_id',
                'l.montant',
                DB::raw('SUM(l.rebate) as rebate'),
            ])
            ->join('vente_reglements_client as r', 'l.reglement_id', '=', 'r.REGLEMENT_ID')
            ->join('vente_livraison as lv', 'lv.LIVRAISON_ID', '=', 'l.livraison_id')
            ->where('r.VALIDATION', '<>', 0)
            ->where('lv.VALIDATION', '<>', 0)
            ->groupBy(['l.livraison_id', 'l.reglement_id', 'l.montant'])
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 17. VIEW_SALES_LINES
    |--------------------------------------------------------------------------
    */
    public function getViewSalesLines(int $perPage = 15): LengthAwarePaginator
    {
        // Union 1 : Livraisons
        $livraisons = VenteLivraisonLigne::query()
            ->from('view_vente_livraison_ligne as ll')
            ->select([
                DB::raw("'Livraison' as Operation"),
                'll.ID',
                'll.LIVRAISON_ID as N°',
                'l.CLIENT_ID',
                'll.PRODUIT_ID as Produit_id',
                'll.PRODUIT_REFERENCE as Reference_Produit',
                'll.DESIGNATION as Designation',
                'll.Color as Couleur',
                'll.ShopPriceAvg as ShopPriceAvg',
                'l.INS_DATE as INS_DATE',
                'l.UPD_DATE as UPD_DATE',
                'l.LIVRAISON_DATE as LIVRAISON_DATE',
                'l.VALIDATION_DATE as Date_validation',
                'll.QUANTITE as Quantité',
                'll.FREE_QUANTITY as FREE_QUANTITY',
                'll.TAUX_TVA as TVA',
                'll.REMISE as Remise',
                'll.PRIX_UNITAIRE as Prix_de_vente',
                'll.PRIX_ACHAT as Prix_achat',
                'll.Margin as Marge'
            ])
            ->join('vente_livraison as l', function ($join) {
                $join->on('ll.LIVRAISON_ID', '=', 'l.LIVRAISON_ID')
                     ->where('l.VALIDATION', '=', '1');
            });

        // Union 2 : Avoirs
        $avoirs = VenteAvoirLigne::query()
            ->from('vente_avoir_ligne as ll')
            ->select([
                DB::raw("'Avoir' as Operation"),
                'll.ID',
                'll.AVOIR_ID as N°',
                'l.CLIENT_ID',
                'll.PRODUIT_ID as Produit_id',
                'll.PRODUIT_REFERENCE as Reference_Produit',
                'll.DESIGNATION as Designation',
                'll.Couleur as Couleur',
                's.shop_avg_price as ShopPriceAvg',
                'l.INS_DATE as INS_DATE',
                'l.UPD_DATE as UPD_DATE',
                'l.AVOIR_DATE as LIVRAISON_DATE',
                'l.VALIDATION_DATE as Date_validation',
                'll.QUANTITE as Quantité',
                'll.FREE_QUANTITY as FREE_QUANTITY',
                'll.TAUX_TVA as TVA',
                'll.REMISE as Remise',
                'll.PRIX_UNITAIRE as Prix_de_vente',
                'll.PRIX_ACHAT as Prix_achat',
                'll.Margin as Marge'
            ])
            ->join('vente_avoir as l', function ($join) {
                $join->on('ll.AVOIR_ID', '=', 'l.AVROIR_ID')
                     ->where('l.VALIDATION', '=', '1');
            })
            ->join('stock_produit as s', 's.PRODUIT_ID', '=', 'll.PRODUIT_ID');

        // Union principal lancé depuis les Sorties non livrées
        return VenteOrderOutputLigne::query()
            ->from('view_vente_order_output_none_delivered as o')
            ->select([
                DB::raw("'Sortie' as Operation"),
                'o.ID',
                'o.OUTPUT_ID as N°',
                'o.CLIENT_ID',
                'o.PRODUIT_ID as Produit_id',
                'o.PRODUIT_REFERENCE as Reference_Produit',
                'o.DESIGNATION as Designation',
                DB::raw("'Color' as Couleur"),
                DB::raw('0 as ShopPriceAvg'),
                DB::raw('NULL as INS_DATE'),
                DB::raw('NULL as UPD_DATE'),
                'o.LIVRAISON_DATE as LIVRAISON_DATE',
                DB::raw('NULL as Date_validation'),
                'o.QUANTITE as Quantité',
                'o.FREE_QUANTITY as FREE_QUANTITY',
                'o.TAUX_TVA as TVA',
                'o.REMISE as Remise',
                'o.PRIX_UNITAIRE as Prix_de_vente',
                'o.PRIX_UNITAIRE as Prix_achat',
                'o.PRIX_ACHAT as Marge'
            ])
            ->union($livraisons)
            ->union($avoirs)
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 18. VIEW_SALES_OPERATION
    |--------------------------------------------------------------------------
    */
    public function getViewSalesOperationBuilder()
    {
        $avoirs = VenteAvoir::query()
            ->from('vente_avoir as a')
            ->select([
                DB::raw("'AV' as type"),
                'a.AVROIR_ID as LIVRAISON_ID',
                DB::raw('NULL as FactureId'),
                'a.JOURNAL_ID',
                'a.AVOIR_DATE as LIVRAISON_DATE',
                'a.REFERENCE',
                'a.MONTANT_TOTAL',
                'a.TOTAL_REMISE as TotalRemise',
                'a.TOTAL_TVA',
                'a.CLIENT_ID',
                'a.employee_id as EmployeeId',
                DB::raw('NULL as PYEMENT_STATUS'),
                'a.DEPOT_ID',
                'a.VALIDATION',
                'a.VALIDATION_DATE'
            ]);

        return VenteLivraison::query()
            ->from('vente_livraison as l')
            ->select([
                DB::raw("'BL' as type"),
                'l.LIVRAISON_ID',
                'l.FactureId',
                'l.JOURNAL_ID',
                'l.LIVRAISON_DATE',
                'l.REFERENCE',
                'l.MONTANT_TOTAL',
                'l.TotalRemise',
                'l.TOTAL_TVA',
                'l.CLIENT_ID',
                'l.EmployeeId',
                'l.PYEMENT_STATUS',
                'l.DEPOT_ID',
                'l.VALIDATION',
                'l.VALIDATION_DATE'
            ])
            ->union($avoirs);
    }

    public function getViewSalesOperation(int $perPage = 15): LengthAwarePaginator
    {
        return $this->getViewSalesOperationBuilder()->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | 19. VIEW_SALES_OPERATION_FACTURE
    |--------------------------------------------------------------------------
    */
    public function getViewSalesOperationFacture(int $perPage = 15): LengthAwarePaginator
    {
        $subQuery = $this->getViewSalesOperationBuilder();

        return VenteLivraison::query()
            ->from(DB::raw("({$subQuery->toSql()}) as o"))
            ->mergeBindings($subQuery->getQuery())
            ->select([
                'o.type',
                'o.LIVRAISON_ID',
                'o.FactureId',
                'o.JOURNAL_ID',
                'o.LIVRAISON_DATE',
                'o.REFERENCE',
                'o.MONTANT_TOTAL',
                'o.TotalRemise',
                'o.TOTAL_TVA',
                'o.CLIENT_ID',
                'o.EmployeeId',
                'o.PYEMENT_STATUS',
                'o.DEPOT_ID',
                'o.VALIDATION',
                'o.VALIDATION_DATE',
                'c.CLIENT_CODE as Code_client',
                'c.NOM as Client',
                'd.DEPOT_LIBELE as Dépot',
                'u.NOM as Employé',
                'f.REFERENCE as Facture'
            ])
            ->leftJoin('vente_facture as f', function ($join) {
                $join->on('f.FACTURE_ID', '=', 'o.FactureId')
                     ->where('o.type', '=', 'BL')
                     ->where('f.VALIDATION', '<>', 0);
            })
            ->join('vente_client as c', 'c.CLIENT_ID', '=', 'o.CLIENT_ID')
            ->join('stock_depot as d', 'd.DEPOT_ID', '=', 'o.DEPOT_ID')
            ->leftJoin('users as u', 'u.USER_ID', '=', 'o.EmployeeId')
            ->paginate($perPage);
    }
}
