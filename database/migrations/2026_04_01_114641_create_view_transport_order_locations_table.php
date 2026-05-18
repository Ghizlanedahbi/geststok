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
        Schema::create('view_transport_order_locations', function (Blueprint $table) {
            $table->integer('ID');
            $table->integer('OrderID');
            $table->string('RefOrder', 1)->nullable();
            $table->dateTime('DATE_ORDER')->nullable();
            $table->boolean('VALIDATION');
            $table->string('REFERENCE', 1)->nullable();
            $table->integer('CLIENT_ID')->nullable();
            $table->string('Facture', 1)->nullable();
            $table->string('DESCRIPTION', 1)->nullable();
            $table->dateTime('FACTURE_DATE')->nullable();
            $table->integer('FACTURE_ID')->nullable();
            $table->string('CLIENT_CODE', 1)->nullable();
            $table->string('NOM', 1)->nullable();
            $table->integer('SUB_TARJET')->nullable();
            $table->string('depart', 1)->nullable();
            $table->string('arrivee', 1)->nullable();
            $table->integer('PRODUIT_ID')->nullable();
            $table->string('Réf_service', 1)->nullable();
            $table->string('Service', 1)->nullable();
            $table->decimal('PRIX', 12, 4)->nullable();
            $table->integer('NOMBRE_COLIS')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_transport_order_locations');
    }
};
