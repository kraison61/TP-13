<?php

use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/portal', [PortalController::class, 'index'])->name('portal');

Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');

Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');

Route::get('/terms', [TermsController::class, 'index'])->name('terms');