<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockProduitCategorie extends Model
{
    protected $table = 'stock_produits_categorie';
    protected $primaryKey = 'CATEGORIE_ID';
    public $timestamps = false;
}