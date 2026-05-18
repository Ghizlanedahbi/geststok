<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportLine extends Model
{
    // On pointe sur la vue SQL créée par votre script
    protected $table = 'view_transport_line';
    
    // Une vue n'a pas de clé primaire auto-incrémentée
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];
}