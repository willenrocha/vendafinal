<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InstagramProfileLookupController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Api\ExpayWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);
Route::get('/pacotes', PackagesController::class)->name('packages.index');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/checkout/start', [CheckoutController::class, 'start'])->name('checkout.start');
Route::post('/checkout/submit', [CheckoutController::class, 'submit'])->name('checkout.submit');
Route::post('/checkout/pix', [CheckoutController::class, 'pix'])->name('checkout.pix');
Route::post('/checkout/status', [CheckoutController::class, 'status'])->name('checkout.status');

Route::post('/instagram/lookup', InstagramProfileLookupController::class)->name('instagram.lookup');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// Webhooks
Route::post('/api/webhooks/expay', [ExpayWebhookController::class, 'handle'])->name('webhooks.expay');
