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
        Schema::create('view_vente', function (Blueprint $table) {
            $table->string('Type', 1);
            $table->integer('AVROIR_ID');
            $table->string('REFERENCE', 1);
            $table->dateTime('AVOIR_DATE');
            $table->integer('CLIENT_ID')->nullable();
            $table->integer('TTVA')->nullable();
            $table->decimal('MONTANT_TOTAL', 38)->nullable();
            $table->decimal('PAYED', 38)->nullable();
            $table->decimal('TOTAL_REMISE', 38)->nullable();
            $table->string('TOTAL_LETTRES', 1)->nullable();
            $table->decimal('TOTAL_TVA', 38)->nullable();
            $table->integer('JOURNAL_ID')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->integer('DEPOT_ID')->nullable();
            $table->integer('employee_id')->nullable();
            $table->decimal('TotalMargin', 38)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente');
    }
};
