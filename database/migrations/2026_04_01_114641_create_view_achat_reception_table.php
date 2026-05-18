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
        Schema::create('view_achat_reception', function (Blueprint $table) {
            $table->integer('COMMANDE_ID')->nullable();
            $table->integer('RECEPTION_ID');
            $table->string('REFERENCE', 1);
            $table->dateTime('RECEPTION_DATE');
            $table->string('Commande', 1)->nullable();
            $table->string('Livraison', 1);
            $table->dateTime('Date_livraison')->nullable();
            $table->string('Facture', 1)->nullable();
            $table->dateTime('Date_facture')->nullable();
            $table->string('AVOIR_COMPLET_REF', 1)->nullable();
            $table->string('FOURNISSEUR_CODE', 1)->nullable();
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->string('Fournisseur', 1)->nullable();
            $table->decimal('Total_TTC', 38)->nullable();
            $table->decimal('Montant_réel', 38)->nullable();
            $table->decimal('Total_HT', 38)->nullable();
            $table->decimal('TotalRemise', 12, 4);
            $table->decimal('REMISE_GLOBAL', 12, 4);
            $table->decimal('REMISE_PORTION_GLOBAL', 12, 4);
            $table->decimal('Remise_pourcentage', 10)->nullable();
            $table->decimal('CHARGE_GLOBAL', 12, 4);
            $table->decimal('CHARGE_PORTION_GLOBAL', 12, 4);
            $table->decimal('TOTAL_TVA', 38)->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('Date_validation')->nullable();
            $table->decimal('JCredit', 38)->nullable();
            $table->decimal('JRemise', 12, 4)->nullable();
            $table->decimal('Payed', 60);
            $table->decimal('PayedRebat', 60);
            $table->dateTime('Date_Création')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('Date_Modification')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->integer('EmployeeId')->nullable();
            $table->integer('DEPOT_ID')->nullable();
            $table->integer('view_achat_credit_fournisseur')->nullable();
            $table->string('Depot', 1)->nullable();
            $table->string('Utilisateur', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_achat_reception');
    }
};
