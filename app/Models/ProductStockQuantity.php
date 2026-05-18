<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStockQuantity extends Model
{
    protected $table = 'stock_quantities';
    protected $primaryKey = 'produit_id';
    public $timestamps = false;
    protected $guarded = [];
}
