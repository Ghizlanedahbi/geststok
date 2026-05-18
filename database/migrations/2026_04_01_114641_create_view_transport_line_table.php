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
        Schema::create('view_transport_line', function (Blueprint $table) {
            $table->integer('ID');
            $table->string('type', 1);
            $table->integer('CLIENT_ID')->nullable();
            $table->string('Référence', 1)->nullable();
            $table->dateTime('Arrivée')->nullable();
            $table->string('Description', 1)->nullable();
            $table->integer('FACTURE_ID')->nullable();
            $table->integer('ORDER_ID')->nullable();
            $table->decimal('Prix', 12, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_transport_line');
    }
};
