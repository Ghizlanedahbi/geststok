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
        Schema::create('view_reglement_livraison_remise', function (Blueprint $table) {
            $table->integer('LIVRAISON_ID');
            $table->integer('REGLEMENT_ID');
            $table->integer('BANQUE_ID')->nullable();
            $table->integer('MODE_PAIMENT_ID');
            $table->integer('FACTURE_ID')->nullable();
            $table->integer('CLIENT_ID');
            $table->string('CLIENT_CODE', 1);
            $table->string('CLIENT', 1);
            $table->string('REF_REGLEMENT', 1)->nullable();
            $table->dateTime('REGLEMENT_DATE');
            $table->string('REF_LIVRAISON', 1);
            $table->dateTime('LIVRAISON_DATE');
            $table->string('REF_FACTURE', 1)->nullable();
            $table->dateTime('FACTURE_DATE')->nullable();
            $table->decimal('MONTANT_INITIAL', 38);
            $table->decimal('MONTANT_PAYE', 38)->nullable();
            $table->decimal('REMISE_APPLIQUEE', 12)->nullable();
            $table->longText('DESCRIPTION')->nullable();
            $table->string('MODE_PAIMANT', 1);
            $table->string('BANQUE', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_reglement_livraison_remise');
    }
};
