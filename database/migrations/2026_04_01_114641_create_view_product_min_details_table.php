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
        Schema::create('view_product_min_details', function (Blueprint $table) {
            $table->integer('PRODUIT_ID');
            $table->string('ref', 1);
            $table->string('Produit', 1);
            $table->string('Couleur', 1)->nullable();
            $table->string('Categorie', 1)->nullable();
            $table->string('Famille', 1)->nullable();
            $table->decimal('PU', 38);
            $table->decimal('PA', 38, 4);
            $table->decimal('PMA', 38, 4);
            $table->decimal('PVMin', 38);
            $table->decimal('FRAIS_DIVERS', 38);
            $table->decimal('Seuil', 38);
            $table->decimal('Marge', 38);
            $table->decimal('PDA', 38, 4);
            $table->decimal('PRIX_BASE1', 12);
            $table->decimal('PRIX_BASE2', 12);
            $table->decimal('PRIX_REVIENT', 12);
            $table->decimal('POID', 38)->nullable();
            $table->decimal('Qte', 54)->nullable();
            $table->boolean('INVENTORIE');
            $table->integer('UNITE_ID');
            $table->string('Unite', 1)->nullable();
            $table->integer('TTVA');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_product_min_details');
    }
};
