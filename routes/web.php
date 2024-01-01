<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AnimalOfferController;
use App\Http\Controllers\AnimalProfileController;
use App\Http\Controllers\AvailableConnectionsController;
use App\Http\Controllers\DeletedAnimalsController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FinancesController;
use App\Http\Controllers\ForSaleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LitterController;
use App\Http\Controllers\LitterGalleryController;
use App\Http\Controllers\MassDataController;
use App\Http\Controllers\PossibleOffspringController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SoldController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\WinteringController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index'])->name('webpage');
// Route::get('/profile/{tag}', [WebController::class, 'index']);

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/zh', [HomeController::class, 'index'])->name('zh');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');  // Settings of Dashboard
        Route::get('/web', [SettingsController::class, 'webIndex'])->name('web'); // Setiings of webpage
    });

    Route::get('forsale', [ForSaleController::class, 'index'])->name('forsale');
    Route::get('sold', [SoldController::class, 'index'])->name('sold');
    Route::get('deleted', [DeletedAnimalsController::class, 'index'])->name('deleted');
    Route::get('animals.sell/{id}', [AnimalOfferController::class, 'sell'])->name('sell');
    Route::get('possibleoffspring', [PossibleOffspringController::class, 'index'])->name('possibleoffspring');
    Route::get('massdata', [MassDataController::class, 'index'])->name('massdata');
    Route::get('winterings', [WinteringController::class, 'index'])->name('winterings');

    Route::resource('availableconnections', AvailableConnectionsController::class)->only(['index', 'show']);
    Route::resource('animals', AnimalController::class);
    Route::resource('finances', FinancesController::class);
    Route::resource('feeds', FeedController::class)->names(['show' => 'feed.profile']);
    Route::resource('offers', AnimalOfferController::class);
    Route::resource('litters', LitterController::class);
    Route::resource('litters.gallery', LitterGalleryController::class);

    // to refactor to nested resource (dot notation)
    Route::post('offers/reservation', [AnimalOfferController::class, 'destroyReservation'])->name('offers.destroyreservation');
    Route::prefix('/animal')->name('animal.')->group(function () {
        Route::get('/{id}', [AnimalProfileController::class, 'index'])->name('profile')->where('id', '[0-9]+');
        Route::post('/gallery/{id}', [AnimalProfileController::class, 'imageUpload'])->name('gallery')->where('id', '[0-9]+');
        Route::get('/imagedelete/{id}', [AnimalProfileController::class, 'imagedelete'])->name('imagedelete')->where('id', '[0-9]+');
        Route::get('/imagesetmain/{id}', [AnimalProfileController::class, 'imagesetmain'])->name('imagesetmain')->where('id', '[0-9]+');
    });
});
