<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportConducteur extends Model
{
    protected $table = 'transport_vehicule_conducteur';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $guarded = [];
}