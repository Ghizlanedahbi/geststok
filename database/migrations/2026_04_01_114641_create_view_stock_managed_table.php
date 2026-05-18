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
        Schema::create('view_stock_managed', function (Blueprint $table) {
            $table->integer('PRODUIT_ID');
            $table->integer('DEPOT_ID');
            $table->integer('UNITE_ID');
            $table->integer('STATUT_ID');
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->decimal('StockPRIX_ACHAT', 38, 4);
            $table->decimal('Quantité', 33)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_stock_managed');
    }
};
