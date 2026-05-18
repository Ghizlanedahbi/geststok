<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $table = 'prod_productions';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
