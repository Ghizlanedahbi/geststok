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
        Schema::create('view_vente_livraison2', function (Blueprint $table) {
            $table->integer('N°');
            $table->string('Réf', 1);
            $table->dateTime('Date_livraison');
            $table->string('Code_Client', 1);
            $table->string('Client', 1);
            $table->decimal('Total_HT', 38)->nullable();
            $table->decimal('Total_TTC', 38);
            $table->decimal('Payé', 38)->nullable();
            $table->decimal('Total_remise', 12)->nullable();
            $table->decimal('Total_TVA', 38)->nullable();
            $table->date('Echéance')->nullable();
            $table->boolean('Validation');
            $table->dateTime('Date_validation')->nullable();
            $table->dateTime('Date_création')->nullable();
            $table->dateTime('Date_modification')->nullable();
            $table->string('Dépot', 1);
            $table->string('Utilisateur', 1);
            $table->integer('CLIENT_ID')->nullable();
            $table->integer('EmployeeId')->nullable();
            $table->integer('FactureId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_livraison2');
    }
};
