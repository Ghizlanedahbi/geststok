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
        Schema::create('view_achat_reglement_fournisseur', function (Blueprint $table) {
            $table->integer('REGLEMENT_ID');
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->integer('JOURNAL_ID')->nullable();
            $table->string('REFERENCE', 1)->nullable();
            $table->longText('DESCRIPTION')->nullable();
            $table->dateTime('REGLEMENT_DATE');
            $table->decimal('MONTANT', 38, 4)->nullable();
            $table->integer('MODE_DE_PAIMENT_ID')->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->string('RECEPTION_REFERENCE', 1)->nullable();
            $table->string('ChequeNum', 1)->nullable();
            $table->dateTime('ChequeEcheance')->nullable();
            $table->integer('reception_id')->nullable();
            $table->string('Compte', 1)->nullable();
            $table->string('Holder', 1)->nullable();
            $table->integer('banque_id')->nullable();
            $table->boolean('cancled')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('FOURNISSEUR_CODE', 1)->nullable();
            $table->string('Fournisseur', 1)->nullable();
            $table->string('Utilisateur', 1)->nullable();
            $table->string('Mode_Paiement', 1)->nullable();
            $table->string('Banque', 1)->nullable();
            $table->integer('status')->nullable();
            $table->dateTime('date_status')->nullable();
            $table->dateTime('date_valeur')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_achat_reglement_fournisseur');
    }
};
