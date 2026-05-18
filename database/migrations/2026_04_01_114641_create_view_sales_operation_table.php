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
        Schema::create('view_sales_operation', function (Blueprint $table) {
            $table->string('type', 1);
            $table->integer('LIVRAISON_ID');
            $table->integer('FactureId')->nullable();
            $table->integer('JOURNAL_ID')->nullable();
            $table->dateTime('LIVRAISON_DATE');
            $table->string('REFERENCE', 1);
            $table->decimal('MONTANT_TOTAL', 38)->nullable();
            $table->decimal('TotalRemise', 38)->nullable();
            $table->decimal('TOTAL_TVA', 38)->nullable();
            $table->integer('CLIENT_ID')->nullable();
            $table->integer('EmployeeId')->nullable();
            $table->integer('PYEMENT_STATUS')->nullable();
            $table->integer('DEPOT_ID')->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_sales_operation');
    }
};
