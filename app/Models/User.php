<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Table physique en base de données
    protected $table = 'users';

    // Clé primaire personnalisée (souvent en majuscules dans vos scripts)
    protected $primaryKey = 'USER_ID';

    public $timestamps = false;

    /**
     * Champs à masquer lors de l'envoi en JSON (Sécurité)
     */
    protected $hidden = [
        'PASSWORD',
    ];

    /**
     * Conversion automatique des types de colonnes
     */
    protected $casts = [
        'ACTIF'                            => 'boolean',
        'Blocked'                          => 'boolean',
        'month_salery'                     => 'decimal:2',
        'product_provisioning_fix'         => 'decimal:2',
        'product_provisioning_rel'         => 'decimal:2',
        'product_provisioning_fix_per_qty' => 'decimal:2',
        'INS_DATE'                         => 'datetime',
        'UPD_DATE'                         => 'datetime',
    ];
}