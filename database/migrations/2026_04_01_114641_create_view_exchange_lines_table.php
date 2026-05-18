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
        Schema::create('view_exchange_lines', function (Blueprint $table) {
            $table->integer('ID');
            $table->integer('CLIENT_ID')->nullable();
            $table->string('Code_client', 1);
            $table->string('Client', 1);
            $table->dateTime('Date');
            $table->string('Réf_operation', 1);
            $table->decimal('Qté', 38);
            $table->string('Réf_produit', 1)->nullable();
            $table->string('Produit', 1);
            $table->string('Couleur', 1)->nullable();
            $table->integer('CategorieID');
            $table->string('Categorie', 1);
            $table->integer('PRODUIT_ID');
            $table->decimal('Prix', 38)->nullable();
            $table->decimal('Remise', 10, 0)->nullable();
            $table->integer('TVA')->nullable();
            $table->boolean('IsOutput');
            $table->boolean('LOCK_OUT');
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_exchange_lines');
    }
};
