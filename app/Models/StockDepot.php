<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockDepot extends Model
{
    protected $table = 'stock_depot';
    protected $primaryKey = 'DEPOT_ID';
    public $timestamps = false;
}