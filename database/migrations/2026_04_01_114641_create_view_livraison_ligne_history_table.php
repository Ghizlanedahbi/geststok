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
        Schema::create('view_livraison_ligne_history', function (Blueprint $table) {
            $table->integer('LIVRAISON_ID')->nullable();
            $table->dateTime('LIVRAISON_DATE')->nullable();
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->integer('CLIENT_ID');
            $table->string('CLIENT_CODE', 1);
            $table->string('NOM', 1);
            $table->integer('PRODUIT_ID')->nullable();
            $table->string('PRODUIT_REFERENCE', 1);
            $table->string('DESIGNATION', 1)->nullable()->comment('NOM PRODUIT');
            $table->decimal('QUANTITE', 12, 4)->nullable();
            $table->decimal('PRIX_UNITAIRE', 12, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_livraison_ligne_history');
    }
};
