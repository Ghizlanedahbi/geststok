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
        Schema::create('view_stock_managed_kernel', function (Blueprint $table) {
            $table->string('Réf', 1);
            $table->string('Désignation', 1);
            $table->decimal('PA', 38, 4);
            $table->decimal('PV', 38);
            $table->decimal('PVM', 38);
            $table->decimal('Seuil', 38);
            $table->decimal('Marge', 38);
            $table->decimal('Frais_divers', 38);
            $table->string('Statut', 1);
            $table->string('Couleur', 1)->nullable();
            $table->string('Categorie', 1);
            $table->string('famille', 1)->nullable();
            $table->string('Unité', 1);
            $table->string('Fournisseur', 1)->nullable();
            $table->string('Dépot', 1);
            $table->integer('id');
            $table->integer('produit_id');
            $table->integer('depot_id');
            $table->integer('unit_id');
            $table->integer('statut_id');
            $table->integer('fournisseur_id')->nullable();
            $table->decimal('PA_STOCK', 32, 4);
            $table->decimal('quantity', 32);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_stock_managed_kernel');
    }
};
