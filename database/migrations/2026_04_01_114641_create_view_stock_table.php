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
        Schema::create('view_stock', function (Blueprint $table) {
            $table->integer('PRODUIT_ID');
            $table->string('REFERENCE', 1);
            $table->string('NOM1', 1);
            $table->string('NOM2', 1)->nullable();
            $table->string('NOM3', 1)->nullable();
            $table->integer('UNITE_ID');
            $table->string('UNITE_LIBELE', 1);
            $table->decimal('Quantité', 33)->nullable();
            $table->decimal('STOCK_SEUIL', 38);
            $table->integer('DEPOT_ID');
            $table->string('DEPOT_LIBELE', 1);
            $table->decimal('STOCK_PRIX_ACHAT', 38, 4);
            $table->decimal('PRIX_ACHAT', 38, 4);
            $table->decimal('PRIX_VENTE', 38);
            $table->decimal('FRAIS_DIVERS', 38);
            $table->decimal('MARGE', 38);
            $table->string('COULEUR', 1)->nullable();
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->string('FOURNISSEUR_NOM', 1)->nullable();
            $table->integer('STATUT_ID');
            $table->string('STATUT_NOM', 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_stock');
    }
};
