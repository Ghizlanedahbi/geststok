<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockQuantities extends Model
{
    protected $table = 'stock_quantities';
    public $timestamps = false;

    protected $guarded = [];
}