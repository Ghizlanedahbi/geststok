<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $primaryKey = 'STOCK_ID';
    public $timestamps = false;

    // Colonnes autorisées pour l'insertion massive
    protected $guarded = [];
}