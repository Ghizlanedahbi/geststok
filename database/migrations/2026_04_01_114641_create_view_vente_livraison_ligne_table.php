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
        Schema::create('view_vente_livraison_ligne', function (Blueprint $table) {
            $table->string('REFERENCE', 1);
            $table->integer('ID');
            $table->integer('LIVRAISON_ID');
            $table->integer('PRODUIT_ID');
            $table->string('PRODUIT_REFERENCE', 1)->nullable();
            $table->string('DESIGNATION', 1)->nullable();
            $table->integer('UNITE_ID')->nullable();
            $table->decimal('QUANTITE', 38);
            $table->decimal('QUANTITE2', 38);
            $table->decimal('PRIX_UNITAIRE', 38);
            $table->integer('TAUX_TVA');
            $table->decimal('REMISE', 10, 0);
            $table->decimal('REMISE_AMOUNT', 12)->nullable();
            $table->decimal('Total', 12)->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->string('NOM1', 1)->nullable();
            $table->string('NOM2', 1)->nullable();
            $table->string('NOM3', 1)->nullable();
            $table->string('PRODUCT_PROPERTY', 1)->nullable();
            $table->dateTime('DATE_EXPIRY')->nullable();
            $table->decimal('PRIX_ACHAT', 38);
            $table->decimal('Margin', 38);
            $table->decimal('ShopPriceAvg', 38)->nullable();
            $table->decimal('POID', 38)->nullable();
            $table->boolean('Inventory');
            $table->integer('OrderId')->nullable();
            $table->decimal('FREE_QUANTITY', 38);
            $table->integer('OUTPUT_ID')->nullable();
            $table->string('Color', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_livraison_ligne');
    }
};
