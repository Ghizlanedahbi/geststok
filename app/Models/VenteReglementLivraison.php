<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteReglementLivraison extends Model
{
    protected $table = 'vente_reglement_livraison';
    
    // Table pivot de liaison sans clé primaire auto-incrémentée standard
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'reglement_id',
        'livraison_id',
        'validate'
    ];
}