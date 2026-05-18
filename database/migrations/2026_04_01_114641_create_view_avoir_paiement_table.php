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
        Schema::create('view_avoir_paiement', function (Blueprint $table) {
            $table->string('Type', 1);
            $table->integer('AVROIR_ID');
            $table->string('Réf', 1);
            $table->dateTime('Date_operation');
            $table->binary('Facture')->nullable();
            $table->integer('CLIENT_ID')->nullable();
            $table->string('Code_Client', 1)->nullable();
            $table->string('Client', 1)->nullable();
            $table->decimal('Montant', 10);
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
        Schema::dropIfExists('view_avoir_paiement');
    }
};
