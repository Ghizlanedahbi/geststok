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
        Schema::create('view_produit', function (Blueprint $table) {
            $table->integer('PRODUIT_ID');
            $table->string('REFERENCE', 1);
            $table->string('NOM1', 1);
            $table->string('NOM2', 1)->nullable();
            $table->string('NOM3', 1)->nullable();
            $table->string('DESIGNATION', 1)->nullable();
            $table->string('DISCRIPTION', 1)->nullable();
            $table->decimal('QUANTITE', 38);
            $table->decimal('PRIX_ACHAT', 38, 4);
            $table->decimal('FRAIS_DIVERS', 38);
            $table->decimal('MARGE', 38);
            $table->decimal('PRIX_VENTE', 38);
            $table->decimal('PRIX_VENTE_MINIMUM', 38);
            $table->integer('TTVA');
            $table->decimal('STOCK_SEUIL', 38);
            $table->integer('CATEGORIE');
            $table->integer('FAMILLE_ID')->nullable();
            $table->integer('UNITE_ID');
            $table->boolean('INVENTORIE');
            $table->string('COULEUR', 1)->nullable();
            $table->binary('PHOTO')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->boolean('is_manufactured')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('is_visible')->nullable();
            $table->decimal('portion_gain', 38)->nullable();
            $table->decimal('shop_avg_price', 38, 4);
            $table->decimal('shop_last_price', 38, 4);
            $table->decimal('POID', 38)->nullable();
            $table->decimal('Quantity', 33)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_produit');
    }
};
