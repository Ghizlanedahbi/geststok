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
        Schema::create('view_products', function (Blueprint $table) {
            $table->string('PRODUIT_REFERENCE', 1)->nullable();
            $table->integer('Product');
            $table->decimal('QUANTITE', 38)->nullable();
            $table->bigInteger('1');
            $table->string('Livraison', 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_products');
    }
};
