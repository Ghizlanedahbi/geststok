<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    // Table physique en base de données
    protected $table = 'charges';
    
    // Clé primaire
    protected $primaryKey = 'id';

    // Désactive les timestamps par défaut de Laravel (created_at/updated_at)
    // car vous utilisez INS_DATE / UPD_DATE manuellement
    public $timestamps = false;

    /**
     * Conversion automatique des types de colonnes
     */
    protected $casts = [
        'date'            => 'date',
        'Montant'         => 'decimal:2',
        'Price'           => 'decimal:2',
        'VALIDATION'      => 'boolean',
        'lock_out'        => 'boolean',
        'INS_DATE'        => 'datetime',
        'VALIDATION_DATE' => 'datetime',
    ];
}