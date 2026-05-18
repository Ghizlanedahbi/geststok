<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('view_jfournisseur', function (Blueprint $table) {
            $table->integer('N°');
            $table->integer('FOURNISSEUR_ID');
            $table->string('Réf', 1);
            $table->dateTime('Date');
            $table->longText('Description')->nullable();
            $table->decimal('Debut', 38);
            $table->decimal('Crédit', 38);
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->string('RCERPTION_REFERENCE', 1)->nullable();
            $table->integer('mode_paiement_id')->nullable();
            $table->string('Type', 1)->nullable();
            $table->boolean('Annulé');
            $table->string('mode_paiementText', 1)->nullable();
            $table->boolean('Fermé')->nullable();
            $table->dateTime('Date fermeture')->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('Echéance')->nullable();
            $table->integer('Operation')->nullable();
            $table->string('Code_fournisseur', 1);
            $table->string('Fournisseur', 1);
            $table->string('Mode_Paiement', 1)->nullable();
            $table->string('Banque', 1)->nullable();
            $table->string('Utilisateur', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_jfournisseur');
    }
};
