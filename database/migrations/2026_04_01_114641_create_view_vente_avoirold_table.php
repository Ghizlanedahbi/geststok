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
        Schema::create('view_vente_avoirold', function (Blueprint $table) {
            $table->integer('AVROIR_ID');
            $table->string('REFERENCE', 1);
            $table->dateTime('AVOIR_DATE');
            $table->string('Code_client', 1);
            $table->string('Client', 1);
            $table->integer('CLIENT_ID')->nullable();
            $table->integer('TTVA')->nullable();
            $table->decimal('MONTANT_TOTAL', 38)->nullable();
            $table->decimal('PAYED', 38)->nullable();
            $table->decimal('TOTAL_REMISE', 38)->nullable();
            $table->string('TOTAL_LETTRES', 1)->nullable();
            $table->decimal('TOTAL_TVA', 38)->nullable();
            $table->integer('JOURNAL_ID')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('Date_création')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('Date_modification')->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('Date_validation')->nullable();
            $table->integer('DEPOT_ID')->nullable();
            $table->string('Dépot', 1);
            $table->integer('USER_ID')->nullable();
            $table->string('Employee', 1)->nullable();
            $table->decimal('TotalMargin', 38)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_avoirold');
    }
};
