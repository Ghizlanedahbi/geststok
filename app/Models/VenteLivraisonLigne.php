<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteLivraisonLigne extends Model
{
    protected $table = 'vente_livraison_ligne';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
