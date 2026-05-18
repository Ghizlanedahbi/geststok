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
        Schema::create('view_articleanalysis_shopping', function (Blueprint $table) {
            $table->string('Operation', 1);
            $table->integer('ReceptionOrAvoir');
            $table->integer('Produit_id');
            $table->string('Reference_Produit', 1)->nullable();
            $table->string('Designation', 1)->nullable();
            $table->string('Couleur', 1)->nullable();
            $table->string('Code Fournisseur', 1);
            $table->string('Fournisseur', 1);
            $table->dateTime('Date_validation')->nullable();
            $table->decimal('PurchasedOrretour', 38)->nullable();
            $table->integer('TVA')->nullable();
            $table->decimal('Remise', 10, 0)->nullable();
            $table->decimal('Prix_achat', 40, 4)->nullable();
            $table->decimal('Prix_de_vente', 38);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_articleanalysis_shopping');
    }
};
