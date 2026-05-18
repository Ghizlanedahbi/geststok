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
        Schema::create('view_product_stock_details', function (Blueprint $table) {
            $table->integer('PRODUIT_ID');
            $table->string('DESIGNATION', 1)->nullable();
            $table->boolean('is_manufactured')->nullable();
            $table->decimal('PRIX_ACHAT', 38, 4);
            $table->decimal('PRIX_VENTE', 38);
            $table->decimal('sum(IFNULL(s.QUANTITE,0))', 33)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_product_stock_details');
    }
};
