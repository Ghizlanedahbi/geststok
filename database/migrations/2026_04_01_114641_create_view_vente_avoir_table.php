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
        Schema::create('view_vente_avoir', function (Blueprint $table) {
            $table->integer('AVROIR_ID');
            $table->string('Réf avoir', 1);
            $table->dateTime('Date_avoir');
            $table->integer('CLIENT_ID')->nullable();
            $table->integer('TTVA')->nullable();
            $table->decimal('TOTAL_HT', 38)->nullable();
            $table->decimal('MONTANT_TOTAL', 38)->nullable();
            $table->decimal('TOTAL_REMISE', 38)->nullable();
            $table->string('TOTAL_LETTRES', 1)->nullable();
            $table->decimal('TOTAL_TVA', 38)->nullable();
            $table->integer('Journal')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('Date_création')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('Date_modification')->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('Date_validation')->nullable();
            $table->integer('DEPOT_ID')->nullable();
            $table->integer('employee_id')->nullable();
            $table->decimal('TotalMargin', 38)->nullable();
            $table->decimal('TauxMargin', 38)->nullable();
            $table->decimal('JCredit', 38)->nullable();
            $table->decimal('Payed', 60);
            $table->string('Employee', 1)->nullable();
            $table->string('Dépot', 1);
            $table->string('Code_client', 1)->nullable();
            $table->string('Client', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_avoir');
    }
};
