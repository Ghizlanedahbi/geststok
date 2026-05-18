<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteReglementsClient extends Model
{
    protected $table = 'vente_reglements_client';
    protected $primaryKey = 'REGLEMENT_ID';
    public $timestamps = false;

    protected $fillable = [
        'REFERENCE',
        'DESCRIPTION',
        'REGLEMENT_DATE',
        'MONTANT',
        'MODE_DE_PAIMENT_ID',
        'VALIDATION',
        'VALIDATION_DATE',
        'INS_USER',
        'INS_DATE',
        'UPD_USER',
        'UPD_DATE',
        'LIVRAISON_REFERENCE',
        'ChequeNum',
        'ChequeEcheance',
        'reception_id',
        'Compte',
        'Holder',
        'banque_id',
        'cancled',
        'user_id',
        'CLIENT_ID',
        'CLIENT_CODE',
        'CLIENT_NOM',
        'Rebate',
        'RebatePortion',
        'status',
        'date_status',
        'date_valeur'
    ];
}