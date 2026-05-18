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
        Schema::create('view_vente_order_output_none_delivered', function (Blueprint $table) {
            $table->string('RefSorie', 1);
            $table->integer('ID');
            $table->integer('OUTPUT_ID');
            $table->integer('LIVRAISON_ID');
            $table->integer('PRODUIT_ID');
            $table->string('PRODUIT_REFERENCE', 1)->nullable();
            $table->string('DESIGNATION', 1)->nullable();
            $table->integer('UNITE_ID')->nullable();
            $table->decimal('QUANTITE', 38);
            $table->decimal('PRIX_UNITAIRE', 38);
            $table->integer('TAUX_TVA');
            $table->decimal('REMISE', 10, 0);
            $table->string('NOM1', 1)->nullable();
            $table->string('NOM2', 1)->nullable();
            $table->string('NOM3', 1)->nullable();
            $table->dateTime('DATE_EXPIRY')->nullable();
            $table->decimal('FREE_QUANTITY', 38);
            $table->decimal('PRIX_ACHAT', 38);
            $table->integer('outPutId');
            $table->string('REFERENCE', 1);
            $table->dateTime('LIVRAISON_DATE');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->boolean('VALIDATION');
            $table->integer('CLIENT_ID')->nullable();
            $table->decimal('MONTANT_TOTAL', 38)->nullable();
            $table->decimal('TotalRemise', 12)->nullable();
            $table->boolean('DELEVERED')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_order_output_none_delivered');
    }
};
