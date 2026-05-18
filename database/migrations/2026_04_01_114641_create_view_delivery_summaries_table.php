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
        Schema::create('view_delivery_summaries', function (Blueprint $table) {
            $table->string('Client', 1)->nullable();
            $table->string('Livraison', 1);
            $table->integer('REGLEMENT_ID')->nullable();
            $table->string('Réglement', 1)->nullable();
            $table->integer('LIVRAISON_ID');
            $table->dateTime('LIVRAISON_DATE');
            $table->integer('CLIENT_ID')->nullable();
            $table->decimal('Montant Total', 38);
            $table->decimal('Montant tva', 38)->nullable();
            $table->decimal('Montant HT', 38)->nullable();
            $table->decimal('Total Marge', 38)->nullable();
            $table->decimal('Total Remise', 12)->nullable();
            $table->integer('banque_id')->nullable();
            $table->boolean('Validé');
            $table->string('banque', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_delivery_summaries');
    }
};
