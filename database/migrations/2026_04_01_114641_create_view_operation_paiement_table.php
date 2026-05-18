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
        Schema::create('view_operation_paiement', function (Blueprint $table) {
            $table->string('Type', 1);
            $table->decimal('Montant', 10)->nullable();
            $table->integer('N°');
            $table->string('Réf', 1);
            $table->dateTime('Date_operation');
            $table->string('Facture', 1)->nullable();
            $table->integer('CLIENT_ID')->nullable();
            $table->string('Code_Client', 1)->nullable();
            $table->string('Client', 1)->nullable();
            $table->decimal('Remise', 38)->nullable();
            $table->decimal('Payed', 60);
            $table->decimal('open_price', 61)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_operation_paiement');
    }
};
