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
        Schema::create('view_prod_productions', function (Blueprint $table) {
            $table->integer('id');
            $table->string('reference', 1);
            $table->dateTime('date_starts')->nullable();
            $table->dateTime('date_ends')->nullable();
            $table->decimal('outlay', 38, 4)->nullable();
            $table->boolean('is_initiate');
            $table->boolean('is_finished');
            $table->boolean('is_active');
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->boolean('VALIDATION');
            $table->dateTime('VALIDATION_DATE')->nullable();
            $table->string('Name', 1)->nullable();
            $table->string('Remark', 1)->nullable();
            $table->integer('task_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->string('Code_fournisseur', 1)->nullable();
            $table->string('Fournisseur', 1)->nullable();
            $table->string('LOGIN', 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_prod_productions');
    }
};
