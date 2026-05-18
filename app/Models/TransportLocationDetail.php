<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportLocationDetail extends Model
{
    protected $table = 'transport_vehicule_ordre_detail_location';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $guarded = [];
}