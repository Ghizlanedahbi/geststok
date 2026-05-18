<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteAvoirLigne extends Model
{
    protected $table = 'vente_avoir_ligne';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
