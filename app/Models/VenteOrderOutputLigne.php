<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteOrderOutputLigne extends Model
{
    protected $table = 'vente_order_output_ligne';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
