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
        Schema::create('view_stock_produit_top_sales', function (Blueprint $table) {
            $table->integer('PID');
            $table->string('PREF', 1);
            $table->string('PNOM', 1);
            $table->string('PCOLOR', 1)->nullable();
            $table->decimal('SALED_QAUNTITY', 60);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_stock_produit_top_sales');
    }
};
