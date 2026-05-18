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
        Schema::create('view_vente_credit_client', function (Blueprint $table) {
            $table->integer('Crédit N°');
            $table->string('REFERENCE', 1)->nullable();
            $table->string('Ref Operation', 1)->nullable();
            $table->dateTime('Date');
            $table->integer('user_id')->nullable();
            $table->integer('CLIENT_ID')->nullable();
            $table->dateTime('Date_validation')->nullable();
            $table->decimal('MONTANT', 38)->nullable();
            $table->integer('JOURNAL_ID')->nullable();
            $table->integer('AvoirId')->nullable();
            $table->string('Propriétaire', 1)->nullable();
            $table->integer('MODE_DE_PAIMENT_ID')->nullable();
            $table->string('Code_client', 1)->nullable();
            $table->string('Client', 1)->nullable();
            $table->string('MODE_PAIMANT', 1)->nullable();
            $table->dateTime('PaiementEcheance')->nullable();
            $table->longText('DESCRIPTION')->nullable();
            $table->string('PaiementNo', 1)->nullable();
            $table->string('Banque', 1)->nullable();
            $table->string('Employee', 1)->nullable();
            $table->boolean('is_credit')->nullable();
            $table->integer('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_credit_client');
    }
};
