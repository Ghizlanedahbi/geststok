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
        Schema::create('view_sales_lines', function (Blueprint $table) {
            $table->string('Operation', 1);
            $table->integer('ID');
            $table->integer('N°');
            $table->integer('CLIENT_ID')->nullable();
            $table->integer('Produit_id');
            $table->string('Reference_Produit', 1)->nullable();
            $table->string('Designation', 1)->nullable();
            $table->string('Couleur', 1)->nullable();
            $table->decimal('ShopPriceAvg', 40, 4)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->dateTime('LIVRAISON_DATE');
            $table->string('Date_validation', 1)->nullable();
            $table->decimal('Quantité', 38);
            $table->decimal('FREE_QUANTITY', 38);
            $table->decimal('TVA', 10, 0)->nullable();
            $table->decimal('Remise', 38);
            $table->decimal('Prix_de_vente', 38);
            $table->decimal('Prix_achat', 38);
            $table->decimal('Marge', 38)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_sales_lines');
    }
};
