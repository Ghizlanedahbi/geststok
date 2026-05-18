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
        Schema::create('view_article_analisis_shop', function (Blueprint $table) {
            $table->string('Operation', 1);
            $table->integer('N°');
            $table->integer('ID');
            $table->string('IDOP', 1);
            $table->string('REFERENCE', 1);
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->integer('Produit_id');
            $table->string('Reference_Produit', 1)->nullable();
            $table->string('Designation', 1)->nullable();
            $table->string('Couleur', 1)->nullable();
            $table->string('Code Fournisseur', 1);
            $table->string('Fournisseur', 1);
            $table->dateTime('INS_DATE')->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->dateTime('RECEPTION_DATE');
            $table->dateTime('Date_validation')->nullable();
            $table->decimal('Quantité', 38)->nullable();
            $table->decimal('Gratuit', 38);
            $table->integer('TVA')->nullable();
            $table->decimal('Remise', 65, 10)->nullable();
            $table->decimal('Prix_achat', 40, 4)->nullable();
            $table->decimal('Prix_de_vente', 38);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_article_analisis_shop');
    }
};
