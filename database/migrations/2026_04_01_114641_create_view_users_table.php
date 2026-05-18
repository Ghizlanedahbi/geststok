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
        Schema::create('view_users', function (Blueprint $table) {
            $table->integer('USER_ID');
            $table->string('CIN', 1)->nullable();
            $table->string('NOM', 1);
            $table->string('PRENOM', 1);
            $table->string('LOGIN', 1);
            $table->string('PASSWORD', 1);
            $table->string('ADRESSE', 1)->nullable();
            $table->string('TEL', 1)->nullable();
            $table->string('MAIL', 1)->nullable();
            $table->integer('ROLE_ID')->nullable();
            $table->boolean('ACTIF');
            $table->string('INS_USER', 1)->nullable();
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->boolean('Blocked')->nullable();
            $table->decimal('product_provisioning_fix', 20)->nullable();
            $table->decimal('product_provisioning_rel', 20)->nullable();
            $table->decimal('product_provisioning_fix_per_qty', 20)->nullable();
            $table->decimal('month_salery', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_users');
    }
};
