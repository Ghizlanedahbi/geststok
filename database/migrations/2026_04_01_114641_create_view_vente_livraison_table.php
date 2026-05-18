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
        Schema::create('view_vente_livraison', function (Blueprint $table) {
            $table->integer('N°');
            $table->string('Réf', 1);
            $table->dateTime('Date_livraison');
            $table->string('Facture', 1)->nullable();
            $table->string('Code_Client', 1)->nullable();
            $table->string('Client', 1)->nullable();
            $table->decimal('Total_HT', 38)->nullable();
            $table->decimal('Total_TTC', 38);
            $table->decimal('Payed', 60);
            $table->decimal('PayedRebat', 60);
            $table->decimal('JDebut', 38)->nullable();
            $table->decimal('JRemise', 38)->nullable();
            $table->decimal('Total_remise', 12)->nullable();
            $table->decimal('Total_TVA', 38)->nullable();
            $table->decimal('Tatal_Marge', 38)->nullable();
            $table->date('Echéance')->nullable();
            $table->boolean('Validation');
            $table->dateTime('Date_validation')->nullable();
            $table->dateTime('Date_création')->nullable();
            $table->dateTime('Date_modification')->nullable();
            $table->string('Dépot', 1)->nullable();
            $table->string('Utilisateur', 1)->nullable();
            $table->integer('CLIENT_ID')->nullable();
            $table->integer('EmployeeId')->nullable();
            $table->integer('FactureId')->nullable();
            $table->boolean('Factured')->nullable();
            $table->decimal('ttaux_marge', 38)->nullable();
            $table->string('AVOIR_COMPLET_REF', 1)->nullable();
            $table->integer('Type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_livraison');
    }
};
