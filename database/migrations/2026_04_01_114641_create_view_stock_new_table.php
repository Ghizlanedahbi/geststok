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
        Schema::create('view_stock_new', function (Blueprint $table) {
            $table->integer('PRODUIT_ID')->nullable();
            $table->string('REFERENCE', 1)->nullable();
            $table->string('DESIGNATION', 1)->nullable();
            $table->string('UNITE', 1)->nullable();
            $table->string('Couleur', 1)->nullable();
            $table->decimal('PRIX_ACHAT', 38, 4)->nullable();
            $table->decimal('StockPRIX_ACHAT', 38, 4);
            $table->decimal('PRIX_VENTE', 38)->nullable();
            $table->decimal('MARGE', 38)->nullable();
            $table->decimal('STOCK_SEUIL', 38)->nullable();
            $table->boolean('INVENTORIE')->nullable();
            $table->integer('DEPOT_ID');
            $table->string('DEPOT_NOM', 1)->nullable();
            $table->integer('VendorId')->nullable();
            $table->string('VendorName', 1)->nullable();
            $table->integer('Statut_Id');
            $table->decimal('Quantité', 33)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_stock_new');
    }
};
