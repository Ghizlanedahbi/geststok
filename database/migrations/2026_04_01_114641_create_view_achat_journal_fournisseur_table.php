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
        Schema::create('view_achat_journal_fournisseur', function (Blueprint $table) {
            $table->integer('JOURNAL_FOURNISSEUR_ID');
            $table->integer('FOURNISSEUR_ID');
            $table->string('REFERENCE', 1);
            $table->dateTime('OPERATION_DATE');
            $table->longText('DESCRIPTION')->nullable();
            $table->decimal('DEBIT', 38);
            $table->decimal('CREDIT', 38);
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->string('RCERPTION_REFERENCE', 1)->nullable();
            $table->integer('lineId')->nullable();
            $table->string('type', 1)->nullable();
            $table->boolean('cancled');
            $table->integer('mode_paiement_id')->nullable();
            $table->string('mode_paiementText', 1)->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('lock_out')->nullable();
            $table->dateTime('lock_out_date')->nullable();
            $table->integer('operation')->nullable();
            $table->dateTime('echeance')->nullable();
            $table->integer('bank_id')->nullable();
            $table->decimal('RebatePortion', 10);
            $table->decimal('Rebate', 12, 4);
            $table->string('FOURNISSEUR_CODE', 1);
            $table->string('Fournisseur', 1);
            $table->string('LOGIN', 1)->nullable();
            $table->string('MODE_PAIMANT', 1)->nullable();
            $table->string('Banque', 1)->nullable();
            $table->string('TEL', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_achat_journal_fournisseur');
    }
};
