<?php


use App\Http\Controllers\AchatController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransportController;
use Illuminate\Support\Facades\Route;

Route::get('/achat/avoir-fournisseur', [AchatController::class, 'avoirFournisseur']);
Route::get('/achat/credit-fournisseur', [AchatController::class, 'creditFournisseur']);
Route::get('/achat/fournisseurs', [AchatController::class, 'fournisseurs']);
Route::get('/achat/journal-fournisseur', [AchatController::class, 'journalFournisseur']);
Route::get('/achat/operations', [AchatController::class, 'operations']);
Route::get('/achat/receptions', [AchatController::class, 'receptions']);
Route::get('/achat/reception-paiement', [AchatController::class, 'receptionPaiement']);
Route::get('/achat/reglement-fournisseur', [AchatController::class, 'reglementFournisseur']);
Route::get('/achat/reception-avoir', [AchatController::class, 'receptionAvoir']);
Route::get('/achat/reception-avoir-base', [AchatController::class, 'receptionAvoirBase']);

Route::get('/stock', [StockController::class, 'stock']);
Route::get('/stock/by-deposit', [StockController::class, 'stockByDeposit']);
Route::get('/stock/classed-by-keys', [StockController::class, 'stockClassedByKeys']);
Route::get('/stock/detail', [StockController::class, 'stockDetail']);
Route::get('/stock/grouped', [StockController::class, 'stockGrouped']);
Route::get('/stock/managed', [StockController::class, 'stockManaged']);
Route::get('/stock/managed-kernel', [StockController::class, 'stockManagedKernel']);
Route::get('/stock/new', [StockController::class, 'stockNew']);
Route::get('/stock/produit-top-sales', [StockController::class, 'produitTopSales']);
Route::get('/stock/quantite', [StockController::class, 'stockQuantite']);
Route::get('/stock/stock', [StockController::class, 'stockStock']);
Route::get('/stock/moves', [StockController::class, 'stockMoves']);

Route::get('/transport/details-line-by-line', [TransportController::class, 'transportDetailsLineByLine']);
Route::get('/transport/line', [TransportController::class, 'transportLine']);
Route::get('/transport/location-client', [TransportController::class, 'transportLocationClient']);
Route::get('/transport/order-details', [TransportController::class, 'transportOrderDetails']);
Route::get('/transport/order-locations', [TransportController::class, 'transportOrderLocations']);
Route::get('/transport/orders', [TransportController::class, 'transportOrders']);

Route::prefix('finance')->name('api.finance.')->group(function () {
    Route::get('/operation-paiement', [FinanceController::class, 'operationPaiement'])->name('operation.paiement');
    Route::get('/avoir-paiement', [FinanceController::class, 'avoirPaiement'])->name('avoir.paiement');
    Route::get('/reglement-livraison-remise', [FinanceController::class, 'reglementLivraisonRemise'])->name('reglement.livraison.remise');
    Route::get('/livraison-paiement', [FinanceController::class, 'livraisonPaiement'])->name('livraison.paiement');
});

Route::prefix('administration')->name('api.administration.')->group(function () {
    Route::get('/charges', [AdministrationController::class, 'charges'])->name('charges');
    Route::get('/users', [AdministrationController::class, 'users'])->name('users');
});

Route::prefix('analytic')->name('api.analysis.')->group(function () {
    Route::get('/article-analysis', [AnalyticController::class, 'articleAnalysis'])->name('article.analysis');
    Route::get('/article-analysis-delevered', [AnalyticController::class, 'articleAnalysisDelevered'])->name('article.analysis.delevered');
    Route::get('/article-analysis-sales', [AnalyticController::class, 'articleAnalysisSales'])->name('article.analysis.sales');
    Route::get('/article-analysis-shopping', [AnalyticController::class, 'articleAnalysisShopping'])->name('article.analysis.shopping');
    Route::get('/stock-produit-top-sales', [AnalyticController::class, 'stockProduitTopSales'])->name('stock.top.sales');
});

Route::prefix('ventes')->name('api.ventes.')->group(function () {
    Route::get('/', [VenteController::class, 'ventes'])->name('index');
    Route::get('/avoirs', [VenteController::class, 'avoirs'])->name('avoirs');
    Route::get('/avoirs-old', [VenteController::class, 'avoirsOld'])->name('avoirs.old');
    Route::get('/clients', [VenteController::class, 'clients'])->name('clients');
    Route::get('/credit-bon-achat', [VenteController::class, 'creditBonAchat'])->name('credit.bon-achat');
    Route::get('/credit-client', [VenteController::class, 'creditClient'])->name('credit.client');
    Route::get('/factures', [VenteController::class, 'factures'])->name('factures');
    Route::get('/jclient', [VenteController::class, 'jClient'])->name('jclient');
    Route::get('/livraisons', [VenteController::class, 'livraisons'])->name('livraisons');
    Route::get('/livraisons2', [VenteController::class, 'livraisons2'])->name('livraisons2');
    Route::get('/livraisons/lignes', [VenteController::class, 'livraisonLignes'])->name('livraisons.lignes');
    Route::get('/livraisons/{id}/lignes', [VenteController::class, 'livraisonLignesByLivraison'])->name('livraisons.lignes.by-livraison');
    Route::get('/order-output', [VenteController::class, 'orderOutput'])->name('order.output');
    Route::get('/order-output-all', [VenteController::class, 'orderOutputAll'])->name('order.output.all');
    Route::get('/order-output-none-delivered', [VenteController::class, 'orderOutputNoneDelivered'])->name('order.none-delivered');
    Route::get('/reglements-client', [VenteController::class, 'reglementsClient'])->name('reglements.client');
    Route::get('/valide-reglement-livraison', [VenteController::class, 'valideReglementLivraison'])->name('valide.reglement.livraison');
    Route::get('/sales-lines', [VenteController::class, 'salesLines'])->name('sales.lines');
    Route::get('/sales-operations', [VenteController::class, 'salesOperations'])->name('sales.operations');
    Route::get('/sales-operation-facture', [VenteController::class, 'salesOperationFacture'])->name('sales.operation.facture');
    Route::get('/article-analysis', [VenteController::class, 'articleAnalysisSales'])->name('article.analysis');
    Route::get('/livraisons/{id}', [VenteController::class, 'showLivraison'])->name('livraisons.show');
    Route::get('/factures/{id}', [VenteController::class, 'showFacture'])->name('factures.show');

   
});
