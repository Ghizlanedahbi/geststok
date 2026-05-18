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
        Schema::create('view_product_min_details2', function (Blueprint $table) {
            $table->integer('depot_id')->nullable();
            $table->integer('PRODUIT_ID');
            $table->string('ref', 1);
            $table->string('Produit', 1);
            $table->string('Couleur', 1)->nullable();
            $table->string('Categorie', 1)->nullable();
            $table->string('Famille', 1)->nullable();
            $table->decimal('PU', 38);
            $table->decimal('PA', 38, 4);
            $table->decimal('Qte', 54)->nullable();
            $table->integer('UNITE_ID');
            $table->string('unite', 1)->nullable();
            $table->integer('TTVA');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_product_min_details2');
    }
};
