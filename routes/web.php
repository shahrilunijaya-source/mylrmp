<?php

use App\Http\Controllers\Industri\ApplicationController;
use App\Http\Controllers\Industri\PemeriksaanController as IndustriPemeriksaanController;
use App\Http\Controllers\Industri\AuthController;
use App\Http\Controllers\Industri\CertificateController;
use App\Http\Controllers\Industri\CompanyRegistrationController;
use App\Http\Controllers\Industri\IndustriDashboardController;
use App\Http\Controllers\Industri\ProfileController;
use App\Http\Controllers\Officer\AuditController as OfficerAuditController;
use App\Http\Controllers\Officer\InspectionController as OfficerInspectionController;
use App\Http\Controllers\Officer\PremisesController as OfficerPremisesController;
use App\Http\Controllers\Officer\ApplicationController as OfficerApplicationController;
use App\Http\Controllers\Officer\AuthController as OfficerAuthController;
use App\Http\Controllers\Officer\CompanyController as OfficerCompanyController;
use App\Http\Controllers\Officer\DashboardController as OfficerDashboardController;
use App\Http\Controllers\Officer\ProductController as OfficerProductController;
use App\Http\Controllers\Officer\ProfileController as OfficerProfileController;
use App\Http\Controllers\Officer\UserController as OfficerUserController;
use App\Http\Controllers\Public\CalculatorController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductSearchController;
use Illuminate\Support\Facades\Route;

// Demo quick-login (only works with real credentials — no bypass)
Route::post('/admin-demo-login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);
    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/admin');
    }
    return redirect()->back()->withErrors(['email' => 'Kelayakan tidak sah.']);
})->middleware(['web'])->name('demo.login');

// Language switcher
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ms', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// Public portal (no auth required)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [ProductSearchController::class, 'index'])->name('products.search');
Route::get('/produk/{product}', [ProductSearchController::class, 'show'])->name('products.show');
Route::get('/kalkulator', [CalculatorController::class, 'index'])->name('calculator');

// Redirect /dashboard based on role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user?->hasRole('Industri')) {
        return redirect()->route('industri.dashboard');
    }

    if ($user?->hasAnyRole(['Super Admin', 'Pendaftar', 'Penilai Teknikal', 'Penilai Label', 'Pegawai Pendaftaran', 'Pegawai Pemeriksaan'])) {
        return redirect()->route('officer.dashboard');
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
        Route::get('/pemeriksaan', [IndustriPemeriksaanController::class, 'index'])->name('pemeriksaan.index');
        Route::get('/pemeriksaan/{inspection}', [IndustriPemeriksaanController::class, 'show'])->name('pemeriksaan.show');
        Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
        Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profil/kata-laluan', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });

// Industri auth (public)
Route::get('/industri/login', [AuthController::class, 'showLogin'])->name('industri.login');
Route::post('/industri/login', [AuthController::class, 'login'])->name('industri.login.store');
Route::post('/industri/logout', [AuthController::class, 'logout'])->name('industri.logout');

// Company self-registration (public)
Route::get('/daftar-industri', [CompanyRegistrationController::class, 'create'])->name('industri.register');
Route::post('/daftar-industri', [CompanyRegistrationController::class, 'store'])->name('industri.register.store');

// Officer portal auth (public)
Route::get('/pegawai/login', [OfficerAuthController::class, 'showLogin'])->name('officer.login');
Route::post('/pegawai/login', [OfficerAuthController::class, 'login'])->name('officer.login.store');
Route::post('/pegawai/logout', [OfficerAuthController::class, 'logout'])->name('officer.logout');

// Officer portal (protected)
Route::prefix('pegawai')->name('officer.')->middleware(['auth', 'officer.role'])->group(function () {
    Route::get('/', [OfficerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/permohonan', [OfficerApplicationController::class, 'index'])->name('applications.index');
    Route::get('/permohonan/{application}', [OfficerApplicationController::class, 'show'])->name('applications.show');
    Route::post('/permohonan/{application}/semak', [OfficerApplicationController::class, 'review'])->name('applications.review');
    Route::get('/pengguna', [OfficerUserController::class, 'index'])->name('users.index');
    Route::get('/syarikat', [OfficerCompanyController::class, 'index'])->name('companies.index');
    Route::get('/syarikat/{company}', [OfficerCompanyController::class, 'show'])->name('companies.show');
    Route::get('/produk', [OfficerProductController::class, 'index'])->name('products.index');
    Route::get('/audit', [OfficerAuditController::class, 'index'])->name('audit.index');
    Route::get('/profil', [OfficerProfileController::class, 'index'])->name('profile');
    Route::patch('/profil', [OfficerProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profil/kata-laluan', [OfficerProfileController::class, 'updatePassword'])->name('profile.password');

    // Premises (kedai/premis)
    Route::get('/premis', [OfficerPremisesController::class, 'index'])->name('premis.index');
    Route::get('/premis/baru', [OfficerPremisesController::class, 'create'])->name('premis.create');
    Route::post('/premis', [OfficerPremisesController::class, 'store'])->name('premis.store');
    Route::get('/premis/{premis}', [OfficerPremisesController::class, 'show'])->name('premis.show');
    Route::get('/premis/{premis}/sunting', [OfficerPremisesController::class, 'edit'])->name('premis.edit');
    Route::patch('/premis/{premis}', [OfficerPremisesController::class, 'update'])->name('premis.update');

    // Inspections (pemeriksaan)
    Route::get('/pemeriksaan', [OfficerInspectionController::class, 'index'])->name('pemeriksaan.index');
    Route::get('/pemeriksaan/jadual', [OfficerInspectionController::class, 'create'])->name('pemeriksaan.create');
    Route::post('/pemeriksaan', [OfficerInspectionController::class, 'store'])->name('pemeriksaan.store');
    Route::get('/pemeriksaan/{inspection}', [OfficerInspectionController::class, 'show'])->name('pemeriksaan.show');
    Route::post('/pemeriksaan/{inspection}/mula', [OfficerInspectionController::class, 'start'])->name('pemeriksaan.start');
    Route::get('/pemeriksaan/{inspection}/jalankan', [OfficerInspectionController::class, 'conduct'])->name('pemeriksaan.conduct');
    Route::post('/pemeriksaan/{inspection}/batal', [OfficerInspectionController::class, 'cancel'])->name('pemeriksaan.cancel');
    Route::get('/pemeriksaan/{inspection}/laporan/muat-turun', [OfficerInspectionController::class, 'downloadReport'])->name('pemeriksaan.report.download');
    Route::get('/pemeriksaan/{inspection}/notis/muat-turun', [OfficerInspectionController::class, 'downloadNotice'])->name('pemeriksaan.notice.download');
});
