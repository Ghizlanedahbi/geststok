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
        Schema::create('view_transport_orders', function (Blueprint $table) {
            $table->integer('ID');
            $table->string('Responsable', 1)->nullable();
            $table->string('Condicteur1', 1)->nullable();
            $table->string('Condicteur2', 1)->nullable();
            $table->string('Vehicule', 1)->nullable();
            $table->string('Trajet', 1)->nullable();
            $table->dateTime('Date_depart')->nullable();
            $table->dateTime('Date_arrivée')->nullable();
            $table->integer('Poid')->nullable();
            $table->decimal('Montant', 38, 4)->nullable();
            $table->boolean('Validé');
            $table->dateTime('Date_validation')->nullable();
            $table->string('Remarque', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_transport_orders');
    }
};
