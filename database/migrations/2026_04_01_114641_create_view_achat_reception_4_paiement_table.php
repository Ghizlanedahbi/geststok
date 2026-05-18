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
        Schema::create('view_achat_reception_4_paiement', function (Blueprint $table) {
            $table->integer('ID');
            $table->string('Réf', 1);
            $table->dateTime('Date');
            $table->string('Livraison', 1);
            $table->dateTime('Date livraison')->nullable();
            $table->string('Facture', 1)->nullable();
            $table->dateTime('Date facture')->nullable();
            $table->string('FOURNISSEUR_CODE', 1);
            $table->string('Fournisseur', 1);
            $table->decimal('Total_TTC', 38)->nullable();
            $table->decimal('Montant_réel', 38)->nullable();
            $table->decimal('Total_HT', 38)->nullable();
            $table->decimal('TotalRemise', 12, 4);
            $table->decimal('REMISE_GLOBAL', 12, 4);
            $table->decimal('REMISE_PORTION_GLOBAL', 12, 4);
            $table->decimal('CHARGE_GLOBAL', 12, 4);
            $table->decimal('CHARGE_PORTION_GLOBAL', 12, 4);
            $table->decimal('TOTAL_TVA', 38)->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->dateTime('Date_Création')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('Date_Modification')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->integer('EmployeeId')->nullable();
            $table->integer('DEPOT_ID')->nullable();
            $table->integer('CommandeId')->nullable();
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->decimal('JCredit', 38);
            $table->decimal('JRemise', 12, 4);
            $table->decimal('Remise_pourcentage', 10);
            $table->decimal('Payed', 60)->nullable();
            $table->decimal('PayedRebat', 60)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_achat_reception_4_paiement');
    }
};
