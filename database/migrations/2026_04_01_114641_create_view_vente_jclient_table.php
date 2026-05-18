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
        Schema::create('view_vente_jclient', function (Blueprint $table) {
            $table->integer('JOURNAL_CLIENT_ID');
            $table->integer('CLIENT_ID');
            $table->string('REFERENCE', 1);
            $table->dateTime('JOURNAL_CLIENT_DATE');
            $table->longText('DESCRIPTION')->nullable();
            $table->decimal('DEBUT', 38);
            $table->decimal('CREDIT', 38);
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->string('LIVRAISON_REFERENCE', 1)->nullable();
            $table->integer('VendorId')->nullable();
            $table->decimal('Rebat', 38)->nullable();
            $table->decimal('RebatePortion', 12)->nullable();
            $table->integer('mode_paiement_id')->nullable();
            $table->string('type', 1)->nullable();
            $table->boolean('cancled');
            $table->string('mode_paiementText', 1)->nullable();
            $table->boolean('lock_out')->nullable();
            $table->dateTime('lock_out_date')->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('date_echiance')->nullable();
            $table->integer('operation');
            $table->string('Code_client', 1);
            $table->string('Client', 1);
            $table->string('Mode_Paiement', 1)->nullable();
            $table->string('nom', 1)->nullable();
            $table->string('LOGIN', 1)->nullable();
            $table->string('TEL', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_jclient');
    }
};
