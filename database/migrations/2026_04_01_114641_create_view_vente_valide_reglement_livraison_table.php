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
        Schema::create('view_vente_valide_reglement_livraison', function (Blueprint $table) {
            $table->bigInteger('livraison_id')->nullable();
            $table->bigInteger('reglement_id')->nullable();
            $table->decimal('montant', 38)->nullable();
            $table->decimal('rebate', 60)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_vente_valide_reglement_livraison');
    }
};
