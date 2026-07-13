<?php

use App\Http\Controllers\QuoteController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/portal', [PortalController::class, 'index'])->name('portal');

Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');
Route::post('/voucher/copy', [VoucherController::class, 'storeCopy'])->name('voucher.copy');

Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');

Route::get('/terms', [TermsController::class, 'index'])->name('terms');


Route::prefix('services')->name('frontend.services.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/calculate', [ServiceController::class, 'soilCalculate'])->name('calculate');
    // Route::get('/{slug}', [ServiceController::class, 'show'])->name('show');
});

Route::get('/{slug}', [ServiceController::class, 'show'])->name('frontend.services.show');