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
        Schema::create('view_achat_credit_fournisseur', function (Blueprint $table) {
            $table->integer('CREDIT_ID');
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->integer('JOURNAL_ID')->nullable();
            $table->string('REFERENCE', 1)->nullable();
            $table->string('REFERENCE_OPERATION', 1)->nullable();
            $table->longText('DESCRIPTION')->nullable();
            $table->dateTime('CREDIT_DATE');
            $table->decimal('MONTANT', 38)->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->integer('AvoirId')->nullable();
            $table->string('Numero', 1)->nullable();
            $table->dateTime('Echéance')->nullable();
            $table->integer('mode_paiement_id')->nullable();
            $table->string('Propriétaire', 1)->nullable();
            $table->string('mode_paiement_text', 1)->nullable();
            $table->integer('bank_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('is_credit')->nullable();
            $table->string('FOURNISSEUR_CODE', 1);
            $table->string('Fournisseur', 1);
            $table->string('Utilisateur', 1)->nullable();
            $table->string('Mode_Paiement', 1)->nullable();
            $table->string('Banque', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_achat_credit_fournisseur');
    }
};
