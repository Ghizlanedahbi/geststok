<?php

namespace App\Services;

use App\Models\Charge;
use App\Models\User;
use Exception;

class AdministrationService
{
    /**
     * Correspond à VIEW_CHARGES
     * Récupère toutes les charges avec les jointures catégories, modes de paiement et auteurs (Paginé).
     */
    public function getViewCharges($perPage = 15)
    {
        try {
            return Charge::query()
                ->from('charges as c')
                ->select([
                    'c.id', 'c.reference', 'c.date', 'c.CATEGORIE_CHARGE_ID', 'c.FAMILLE_CHARGE_ID',
                    'c.MODE_PAIMENT_ID', 'c.Intervenant', 'c.Montant', 'c.remark', 'c.Price',
                    'c.date_validation', 'c.date_echeance', 'c.UserId as USER_ID', 'c.paiement_no',
                    'c.paiement_echeance', 'c.LineId', 'c.lock_out', 'c.lock_out_date',
                    'c.bank_id', 'c.holder', 'ca.CATEGORIE_LIBELE', 'c.VALIDATION',
                    'c.VALIDATION_DATE', 'c.status', 'c.date_status', 'c.date_valeur',
                    'cf.LIBELE AS FAMILLE_LIBELE', 'm.MODE_PAIMANT', 'u.LOGIN'
                ])
                ->join('categorie_charge as ca', 'ca.CATEGORIE_CHARGE_ID', '=', 'c.CATEGORIE_CHARGE_ID')
                ->join('modes_paiement as m', 'm.MODE_PAIMENT_ID', '=', 'c.MODE_PAIMENT_ID')
                ->join('users as u', 'u.USER_ID', '=', 'c.UserId')
                ->leftJoin('charge_famille as cf', 'c.FAMILLE_CHARGE_ID', '=', 'cf.ID')
                ->leftJoin('param_banque as b', 'b.id', '=', 'c.bank_id')
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur sécurisée lors de la récupération des charges.");
        }
    }

    /**
     * Correspond à VIEW_USERS
     * Récupère tous les utilisateurs et leurs paramètres (Paginé).
     */
    public function getViewUsers($perPage = 15)
    {
        try {
            return User::query()
                ->select([
                    'USER_ID',
                    'CIN',
                    'NOM',
                    'PRENOM',
                    'LOGIN',
                    'PASSWORD',
                    'ADRESSE',
                    'TEL',
                    'MAIL',
                    'ROLE_ID',
                    'ACTIF',
                    'INS_USER',
                    'INS_DATE',
                    'UPD_USER',
                    'UPD_DATE'
                ])
                ->paginate($perPage);
        } catch (Exception $e) {
            throw new Exception("Erreur sécurisée lors de la récupération des utilisateurs.");
        }
    }
}