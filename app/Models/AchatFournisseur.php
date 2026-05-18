<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchatFournisseur extends Model
{
    protected $table = 'achat_fournisseur';
    protected $primaryKey = 'FOURNISSEUR_ID';
    public $timestamps = false;
}