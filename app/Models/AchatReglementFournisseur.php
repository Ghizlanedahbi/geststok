<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchatReglementFournisseur extends Model
{
    protected $table = 'achat_reglement_fournisseur';
    protected $primaryKey = 'REGLEMENT_ID';
    public $timestamps = false;
}