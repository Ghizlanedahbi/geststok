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
        Schema::create('view_vente_order_output', function (Blueprint $table) {
            $table->integer('ID');
            $table->string('REFERENCE', 1);
            $table->string('Réf_livraison', 1)->nullable();
            $table->integer('LIVRAISON_ID')->nullable();
            $table->dateTime('LIVRAISON_DATE');
            $table->string('REFERENCE_ORIGINE', 1)->nullable();
            $table->integer('CLIENT_ID')->nullable();
            $table->integer('TTVA')->nullable();
            $table->decimal('MONTANT_TOTAL', 38)->nullable();
            $table->decimal('Total_HT', 38)->nullable();
            $table->string('TOTAL_LETTRES', 1)->nullable();
            $table->decimal('TOTAL_TVA', 38)->nullable();
            $table->integer('JOURNAL_ID')->nullable();
            $table->integer('DEPOT_ID')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->date('ECHEANCE')->nullable();
            $table->integer('METHODE_LIVRAISON_ID')->nullable();
            $table->integer('CONDITIONS_REGLEMENT_ID')->nullable();
            $table->integer('EmployeeId')->nullable();
            $table->decimal('TatalMargin', 38)->nullable();
            $table->decimal('TauxMargin', 38)->nullable();
            $table->integer('FactureId')->nullable();
            $table->decimal('Avance', 38)->nullable();
            $table->integer('Commande_Id')->nullable();
            $table->boolean('STATUE')->nullable();
            $table->boolean('IS_CASH')->nullable();
            $table->boolean('DELEVERED')->nullable();
            $table->decimal('TotalRemise', 12)->nullable();
            $table->string('Dépot', 1);
            $table->string('Code_client', 1)->nullable();
            $table->string('Client', 1)->nullable();
            $table->string('Employé', 1);
            $table->boolean('Livré')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_order_output');
    }
};
