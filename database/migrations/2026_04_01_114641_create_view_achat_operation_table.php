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
        Schema::create('view_achat_operation', function (Blueprint $table) {
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->string('Code_fournisseur', 1);
            $table->string('Fournisseur', 1);
            $table->string('Réf', 1);
            $table->dateTime('Date');
            $table->string('Type', 1);
            $table->string('Réf_operation', 1)->nullable();
            $table->dateTime('Date_operation')->nullable();
            $table->decimal('Total_TVA', 38)->nullable();
            $table->decimal('Total_Remise', 12, 4)->nullable();
            $table->decimal('HT', 38)->nullable();
            $table->decimal('Montant', 38)->nullable();
            $table->decimal('Montant_réel', 38)->nullable();
            $table->decimal('Escompte', 39)->nullable();
            $table->decimal('Remise_escompte', 18, 4);
            $table->decimal('Charge_escompte', 18, 4);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_achat_operation');
    }
};
