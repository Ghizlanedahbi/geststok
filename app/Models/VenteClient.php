<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteClient extends Model
{
    protected $table = 'vente_client';
    protected $primaryKey = 'CLIENT_ID';
    public $timestamps = false;
}
