<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportVehicule extends Model
{
    protected $table = 'transport_vehicule';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $guarded = [];
}