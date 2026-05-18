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
        Schema::create('view_vente_facture', function (Blueprint $table) {
            $table->integer('FACTURE_ID');
            $table->string('REFERENCE', 1);
            $table->dateTime('FACTURE_DATE');
            $table->integer('CLIENT_ID')->nullable();
            $table->string('CLIENT_CODE', 1)->nullable();
            $table->string('CLIENT', 1)->nullable();
            $table->integer('TTVA')->nullable();
            $table->decimal('MONTANT_TOTAL', 38)->nullable();
            $table->string('TOTAL_LETTRES', 1)->nullable();
            $table->string('DISIGNATION', 1)->nullable();
            $table->decimal('TOTAL_TVA', 38)->nullable();
            $table->decimal('TotalRemise', 38)->nullable();
            $table->integer('JOURNAL_ID')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->integer('MODE_PAIMENT_ID')->nullable();
            $table->date('ECHEANCE')->nullable();
            $table->integer('CONDITIONS_REGLEMENT_ID')->nullable();
            $table->string('CLIENT_NOM', 1)->nullable();
            $table->string('CLIENT_ADRESS', 1)->nullable();
            $table->string('CHEQUE_NUM', 1)->nullable();
            $table->string('ModePaiementText', 1)->nullable();
            $table->string('MODE_PAIMANT', 1)->nullable();
            $table->string('CLIENT_PHONE', 1)->nullable();
            $table->integer('Livraison_Id')->nullable();
            $table->boolean('AlreadyDelevred')->nullable();
            $table->integer('Type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_facture');
    }
};
