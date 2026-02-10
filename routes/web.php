<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InstagramProfileLookupController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Api\ExpayWebhookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageProxyController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// =========================================
// ROTAS PÚBLICAS (Blade - existentes)
// =========================================
Route::get('/', HomeController::class);
Route::get('/pacotes', PackagesController::class)->name('packages.index');

// Proxy de imagens (para evitar CORS)
Route::get('/proxy-image', [ImageProxyController::class, 'proxyImage']);

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

// =========================================
// PAINEL DO CLIENTE (Inertia + Vue)
// =========================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/switch-profile', [DashboardController::class, 'switchProfile'])->name('dashboard.switch-profile');
    Route::post('/dashboard/redeem-credits', [DashboardController::class, 'redeemCredits'])->name('dashboard.redeem-credits');

    // Pedidos do cliente
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');

    // Ajuda
    Route::get('/help', fn () => Inertia::render('Help'))->name('help');

    // Perfil do cliente
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas de autenticação (login, registro, etc)
require __DIR__.'/auth.php';
