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
        Schema::create('view_stock_quantite', function (Blueprint $table) {
            $table->integer('PRODUIT_ID');
            $table->string('REFERENCE', 1);
            $table->string('DESIGNATION', 1);
            $table->decimal('PRIX_ACHAT', 38, 4);
            $table->decimal('FRAIS_DIVERS', 38);
            $table->string('Couleur', 1)->nullable();
            $table->decimal('MARGE', 38);
            $table->decimal('PRIX_VENTE', 38);
            $table->decimal('STOCK_SEUIL', 38);
            $table->integer('DEPOT_ID');
            $table->integer('UNITE_ID');
            $table->decimal('Quantité', 33)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_stock_quantite');
    }
};
