<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteFacture extends Model
{
    protected $table = 'vente_facture';
    protected $primaryKey = 'FACTURE_ID';
    public $timestamps = false;
}
