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
        Schema::create('view_stock_by_deposit', function (Blueprint $table) {
            $table->integer('PRODUIT_ID');
            $table->integer('DEPOT_ID');
            $table->decimal('sum(s.QUANTITE)', 33)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_stock_by_deposit');
    }
};
