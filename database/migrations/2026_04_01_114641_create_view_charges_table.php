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
        Schema::create('view_charges', function (Blueprint $table) {
            $table->integer('id');
            $table->string('reference', 1)->nullable();
            $table->dateTime('date')->nullable();
            $table->integer('CATEGORIE_CHARGE_ID');
            $table->integer('FAMILLE_CHARGE_ID')->nullable();
            $table->integer('MODE_PAIMENT_ID');
            $table->string('Intervenant', 1)->nullable();
            $table->double('Montant')->nullable();
            $table->longText('remark')->nullable();
            $table->decimal('Price', 38);
            $table->dateTime('date_validation')->nullable();
            $table->dateTime('date_echeance')->nullable();
            $table->integer('USER_ID')->nullable();
            $table->string('paiement_no', 1)->nullable();
            $table->dateTime('paiement_echeance')->nullable();
            $table->integer('LineId')->nullable();
            $table->boolean('lock_out');
            $table->dateTime('lock_out_date')->nullable();
            $table->integer('bank_id')->nullable();
            $table->text('holder')->nullable();
            $table->string('CATEGORIE_LIBELE', 1);
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->integer('status')->nullable();
            $table->dateTime('date_status')->nullable();
            $table->dateTime('date_valeur')->nullable();
            $table->string('FAMILLE_LIBELE', 1)->nullable();
            $table->string('MODE_PAIMANT', 1);
            $table->string('LOGIN', 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_charges');
    }
};
