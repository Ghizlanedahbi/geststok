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
        Schema::create('view_stock_grouped', function (Blueprint $table) {
            $table->integer('PRODUIT_ID');
            $table->integer('DEPOT_ID');
            $table->integer('UNITE_ID');
            $table->integer('STATUT_ID');
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->decimal('PRIX_ACHAT', 38, 4);
            $table->decimal('sum(s.QUANTITE)', 33)->nullable();
            $table->string('REFERENCE', 1);
            $table->string('Desination', 1)->nullable();
            $table->string('FOURNISSEUR_CODE', 1)->nullable();
            $table->string('NOM', 1)->nullable();
            $table->string('STATUT_NOM', 1)->nullable();
            $table->string('Dépot', 1);
            $table->string('Unité', 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_stock_grouped');
    }
};
