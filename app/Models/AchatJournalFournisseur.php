<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchatJournalFournisseur extends Model
{
    protected $table = 'achat_journal_fournisseur';
    protected $primaryKey = 'JOURNAL_FOURNISSEUR_ID';
    public $timestamps = false;
}