<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteLivraison extends Model {
    protected $table = 'vente_livraison';
    protected $primaryKey = 'LIVRAISON_ID';
}

class VenteLivraisonLigne extends Model {
    protected $table = 'vente_livraison_ligne';
}

class VenteAvoir extends Model {
    protected $table = 'vente_avoir';
    protected $primaryKey = 'AVROIR_ID'; // Notez l'orthographe spécifique de votre DB
}

class VenteAvoirLigne extends Model {
    protected $table = 'vente_avoir_ligne';
}

class VenteClient extends Model {
    protected $table = 'vente_client';
    protected $primaryKey = 'CLIENT_ID';
}

class VenteOrderOutput extends Model {
    protected $table = 'vente_order_output';
}

class VenteOrderOutputLigne extends Model {
    protected $table = 'vente_order_output_ligne';
}