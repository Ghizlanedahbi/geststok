<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStockDetail extends Model
{
    protected $table = 'stock_produit';
    protected $primaryKey = 'PRODUIT_ID';
    public $timestamps = false;
    protected $guarded = [];
}
