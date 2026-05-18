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
        Schema::create('view_vente_credit_bon_achat', function (Blueprint $table) {
            $table->string('CLIENT_CODE', 1);
            $table->string('Client', 1);
            $table->string('USER', 1);
            $table->integer('ID');
            $table->integer('CLIENT_ID')->nullable();
            $table->integer('USER_ID')->nullable();
            $table->string('REFERENCE', 1)->nullable();
            $table->longText('DESCRIPTION')->nullable();
            $table->dateTime('REGLEMENT_DATE');
            $table->decimal('MONTANT', 38)->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->dateTime('EXPERATION_DATE')->nullable();
            $table->decimal('RESTE', 38)->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_credit_bon_achat');
    }
};
