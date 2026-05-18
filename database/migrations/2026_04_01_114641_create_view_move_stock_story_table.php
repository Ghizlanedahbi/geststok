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
        Schema::create('view_move_stock_story', function (Blueprint $table) {
            $table->integer('STOCK_ID');
            $table->integer('INVENTAIRE_ID');
            $table->string('Code_fournisseur', 1)->nullable();
            $table->string('nom_fournisseur', 1)->nullable();
            $table->string('REFERENCE', 1);
            $table->string('TYPE_MOUVEMENT', 1)->nullable();
            $table->integer('TYPE_MOUVEMENT_ID');
            $table->dateTime('STOCK_DATE');
            $table->integer('DEPOT_ID');
            $table->string('DEPOT_NOM', 1)->nullable();
            $table->integer('LOT_ID')->nullable();
            $table->string('LOT_NOM', 1)->nullable();
            $table->integer('PRODUIT_ID');
            $table->string('PRODUIT_REFERENCE', 1)->nullable();
            $table->string('DESIGNATION', 1)->nullable();
            $table->string('Couleur', 1)->nullable();
            $table->integer('UNITE_ID');
            $table->string('UNITE', 1)->nullable();
            $table->integer('FOURNISSEUR_ID')->nullable();
            $table->string('FOURNISSEUR_NOM', 1)->nullable();
            $table->decimal('CODE_BARRE', 38, 0)->nullable();
            $table->boolean('INVENTORIE')->nullable();
            $table->integer('STATUT_ID');
            $table->string('SATATUT', 1)->nullable();
            $table->longText('REMARQUE')->nullable();
            $table->decimal('QUANTITE', 11);
            $table->decimal('PRIX_ACHAT', 38);
            $table->decimal('PRIX_ACHAT_PAR_DEFAUT', 38);
            $table->decimal('PRIX_VENTE', 38);
            $table->decimal('PRIX_VENTE_PAR_DEFAUT', 38);
            $table->dateTime('INS_DATE')->nullable();
            $table->string('UPD_USER', 1)->nullable();
            $table->dateTime('UPD_DATE')->nullable();
            $table->string('INS_USER', 1)->nullable();
            $table->integer('lineId')->nullable();
            $table->string('RefType', 1)->nullable();
            $table->integer('move_type_id');
            $table->dateTime('DATE_EXPIRY')->nullable();
            $table->string('Réf_produit', 1);
            $table->string('Names', 1);
            $table->string('DEPOT_LIBELE', 1);
            $table->string('UNITE_LIBELE', 1);
            $table->string('STATUT_NOM', 1);
            $table->string('CLIENT_CODE', 1)->nullable();
            $table->string('NOM', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_move_stock_story');
    }
};
