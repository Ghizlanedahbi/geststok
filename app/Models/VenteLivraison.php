<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteLivraison extends Model
{
    protected $table = 'vente_livraison';
    protected $primaryKey = 'LIVRAISON_ID';
    public $timestamps = false;

    protected $fillable = [
        'REFERENCE',
        'LIVRAISON_DATE',
        'CLIENT_ID',
        'FactureId',
        'MONTANT_TOTAL',
        'TOTAL_TVA',
        'TotalHT',
        'TotalRemise',
        'PAYED',
        'VALIDATION',
        'VALIDATION_DATE',
        'JOURNAL_ID',
        'EmployeeId',
        'PYEMENT_STATUS',
        'DEPOT_ID'
    ];
}