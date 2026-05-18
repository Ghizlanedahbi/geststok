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
        Schema::create('view_vente_reglements_client', function (Blueprint $table) {
            $table->integer('Reglement N°');
            $table->string('Référence', 1)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('Ref livraison', 1)->nullable();
            $table->dateTime('Date');
            $table->integer('CLIENT_ID')->nullable();
            $table->string('Code_client', 1)->nullable();
            $table->string('Client', 1)->nullable();
            $table->decimal('Montant', 38)->nullable();
            $table->boolean('Validation');
            $table->dateTime('Date_validation')->nullable();
            $table->decimal('Remise', 12)->nullable();
            $table->decimal('Remise_%', 12)->nullable();
            $table->integer('MODE_DE_PAIMENT_ID')->nullable();
            $table->string('Mode_paiement', 1);
            $table->integer('banque_id')->nullable();
            $table->string('Banque', 1)->nullable();
            $table->string('Numéro', 1)->nullable();
            $table->string('Propriétaire', 1)->nullable();
            $table->dateTime('Echéance')->nullable();
            $table->integer('status')->nullable();
            $table->dateTime('date_status')->nullable();
            $table->dateTime('date_valeur')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_reglements_client');
    }
};
