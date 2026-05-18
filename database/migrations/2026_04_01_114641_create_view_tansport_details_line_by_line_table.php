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
        Schema::create('view_tansport_details_line_by_line', function (Blueprint $table) {
            $table->integer('ID');
            $table->dateTime('Date_order')->nullable();
            $table->string('RefOrder', 1)->nullable();
            $table->boolean('VALIDATION');
            $table->integer('clientId')->nullable();
            $table->string('CLIENT_CODE', 1)->nullable();
            $table->string('Client', 1)->nullable();
            $table->string('type', 1);
            $table->string('Référence', 1)->nullable();
            $table->dateTime('Arrivée')->nullable();
            $table->string('Description', 1)->nullable();
            $table->integer('FACTURE_ID')->nullable();
            $table->integer('ORDER_ID')->nullable();
            $table->decimal('Prix', 12, 4)->nullable();
            $table->dateTime('Depart')->nullable();
            $table->dateTime('Arrivée_order')->nullable();
            $table->string('RéfFacture', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_tansport_details_line_by_line');
    }
};
