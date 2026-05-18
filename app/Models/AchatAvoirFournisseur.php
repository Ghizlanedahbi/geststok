<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchatAvoirFournisseur extends Model
{
    protected $table = 'achat_avoir_fournisseur';
    protected $primaryKey = 'AVOIR_FOURNISSEUR_ID';
    public $timestamps = false;
}