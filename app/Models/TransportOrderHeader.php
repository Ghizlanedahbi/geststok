<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportOrderHeader extends Model
{
    protected $table = 'transport_vehicule_ordre_header';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $guarded = [];
}