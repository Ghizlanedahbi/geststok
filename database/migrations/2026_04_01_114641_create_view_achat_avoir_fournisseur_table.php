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
        Schema::create('view_achat_avoir_fournisseur', function (Blueprint $table) {
            $table->integer('AVOIR_FOURNISSEUR_ID');
            $table->integer('RECEPTION_ID')->nullable();
            $table->string('REFERENCE', 1);
            $table->dateTime('AVOIR_FOURNISSEUR_DATE');
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->decimal('TOTAL_HT', 38)->nullable();
            $table->decimal('MONTANT_TOTAL', 38)->nullable();
            $table->decimal('TOTAL_TVA', 38)->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->integer('USER_ID')->nullable();
            $table->integer('DEPOT_ID');
            $table->decimal('Payed', 60);
            $table->decimal('JDebut', 38)->nullable();
            $table->string('FOURNISSEUR_CODE', 1)->nullable();
            $table->string('Fournisseur', 1)->nullable();
            $table->text('Depot')->nullable();
            $table->string('Utilisateur', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_achat_avoir_fournisseur');
    }
};
