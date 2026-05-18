<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportTrajet extends Model
{
    protected $table = 'transport_vehicule_trajet';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $guarded = [];
}