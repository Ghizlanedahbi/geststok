<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteJClient extends Model
{
    protected $table = 'vente_jclient';
    protected $primaryKey = 'JOURNAL_CLIENT_ID';
    public $timestamps = false;
}
