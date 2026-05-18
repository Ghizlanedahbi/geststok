<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteCreditClient extends Model
{
    protected $table = 'vente_credit_client';
    protected $primaryKey = 'CREDIT_ID';
    public $timestamps = false;
}
