<?php

use App\Http\Controllers\Industri\ApplicationController;
use App\Http\Controllers\Industri\AuthController;
use App\Http\Controllers\Industri\CertificateController;
use App\Http\Controllers\Industri\CompanyRegistrationController;
use App\Http\Controllers\Industri\IndustriDashboardController;
use App\Http\Controllers\Industri\ProfileController;
use App\Http\Controllers\Public\CalculatorController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductSearchController;
use Illuminate\Support\Facades\Route;

// Public portal (no auth required)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [ProductSearchController::class, 'index'])->name('products.search');
Route::get('/produk/{product}', [ProductSearchController::class, 'show'])->name('products.show');
Route::get('/kalkulator', [CalculatorController::class, 'index'])->name('calculator');

// Redirect /dashboard based on role
Route::get('/dashboard', function () {
    if (auth()->user()?->hasRole('Industri')) {
        return redirect()->route('industri.dashboard');
    }
    return redirect('/admin');
})->middleware('auth')->name('dashboard');

// Industri portal
Route::prefix('industri')
    ->name('industri.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [IndustriDashboardController::class, 'index'])->name('dashboard');
        Route::get('/permohonan', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/permohonan/baru', [ApplicationController::class, 'create'])->name('applications.create');
        Route::get('/permohonan/{application}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::post('/permohonan/{application}/dokumen', [ApplicationController::class, 'uploadDocument'])->name('applications.upload-document');
        Route::get('/sijil/{certificate}/muat-turun', [CertificateController::class, 'download'])->name('certificates.download');
        Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
    });

// Industri auth (public)
Route::get('/industri/login', [AuthController::class, 'showLogin'])->name('industri.login');
Route::post('/industri/login', [AuthController::class, 'login'])->name('industri.login.store');
Route::post('/industri/logout', [AuthController::class, 'logout'])->name('industri.logout');

// Company self-registration (public)
Route::get('/daftar-industri', [CompanyRegistrationController::class, 'create'])->name('industri.register');
Route::post('/daftar-industri', [CompanyRegistrationController::class, 'store'])->name('industri.register.store');
