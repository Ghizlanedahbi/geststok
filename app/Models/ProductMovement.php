<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMovement extends Model
{
    protected $table = 'product_movements'; 
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $guarded = [];
}
