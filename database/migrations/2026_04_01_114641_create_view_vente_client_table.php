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
        Schema::create('view_vente_client', function (Blueprint $table) {
            $table->integer('CLIENT_ID');
            $table->string('CLIENT_CODE', 1);
            $table->string('NOM', 1);
            $table->string('NOM2', 1)->nullable();
            $table->string('ADRESSE', 1)->nullable();
            $table->string('VILLE', 1)->nullable();
            $table->string('TEL', 1)->nullable();
            $table->string('GSM', 1)->nullable();
            $table->string('FAXE', 1)->nullable();
            $table->string('CONTACT', 1)->nullable();
            $table->string('MAIL', 1)->nullable();
            $table->binary('LOGO')->nullable();
            $table->string('IF', 1)->nullable();
            $table->string('PATENTE', 1)->nullable();
            $table->string('RC', 1)->nullable();
            $table->string('CNSS', 1)->nullable();
            $table->decimal('SEUIL_CREDIT', 38);
            $table->decimal('OLD_CREDIT', 38);
            $table->integer('CLIENT_CATEGORIE_ID')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->boolean('DEFAUT');
            $table->boolean('ACTIF');
            $table->string('ICE', 1)->nullable();
            $table->integer('VendorId')->nullable();
            $table->boolean('IS_CONFRERE')->nullable();
            $table->string('CLIENT_CATEGORIE_LIBELE', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_client');
    }
};
