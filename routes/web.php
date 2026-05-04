<?php
// routes/web.php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\LpjController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PeriodController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Proposal Routes
    Route::resource('proposals', ProposalController::class);
    Route::post('/proposals/{proposal}/approve-bem', [ProposalController::class, 'approveBem'])
        ->name('proposals.approve-bem')
        ->middleware('role:bem');
    Route::post('/proposals/{proposal}/approve-admin', [ProposalController::class, 'approveAdmin'])
        ->name('proposals.approve-admin')
        ->middleware('role:admin');
    Route::post('/proposals/{proposal}/reject', [ProposalController::class, 'reject'])
        ->name('proposals.reject')
        ->middleware('role:bem,admin');
    
    // Activity Routes
    Route::resource('activities', ActivityController::class)->only(['index', 'show']);
    Route::post('/activities/{activity}/update-status', [ActivityController::class, 'updateStatus'])
        ->name('activities.update-status')
        ->middleware('role:ormawa,bem');
    Route::post('/activities/{activity}/upload-documentation', [ActivityController::class, 'uploadDocumentation'])
        ->name('activities.upload-documentation')
        ->middleware('role:ormawa,bem');
    
    // LPJ Routes
    Route::get('/activities/{activity}/lpj/create', [LpjController::class, 'create'])
        ->name('lpj.create');
    Route::post('/activities/{activity}/lpj', [LpjController::class, 'store'])
        ->name('lpj.store');
    Route::post('/lpj/{lpj}/verify', [LpjController::class, 'verify'])
        ->name('lpj.verify')
        ->middleware('role:admin');
    
    // Archive Routes
    Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');
    Route::get('/archives/{period}', [ArchiveController::class, 'show'])->name('archives.show');
    Route::get('/archives/{period}/export', [ArchiveController::class, 'exportPDF'])
        ->name('archives.export');
    
    // Report Routes
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index')
        ->middleware('role:admin,bem');
    Route::post('/reports/generate', [ReportController::class, 'generate'])
        ->name('reports.generate')
        ->middleware('role:admin,bem');
    Route::get('/reports/proposal/{proposal}', [ReportController::class, 'proposalDetail'])
        ->name('reports.proposal-detail')
        ->middleware('role:admin,bem');
    
    // Period Management Routes (Admin Only)
    Route::middleware('role:admin')->group(function () {
        Route::post('/periods', [PeriodController::class, 'store'])->name('periods.store');
        Route::patch('/periods/{period}', [PeriodController::class, 'update'])->name('periods.update');
        Route::delete('/periods/{period}', [PeriodController::class, 'destroy'])->name('periods.destroy');
        Route::post('/periods/{period}/activate', [PeriodController::class, 'activate'])->name('periods.activate');
    });
    Route::middleware(['auth', 'verified', 'role:ormawa'])->group(function () {
    
    // Halaman Profil Ormawa
    Route::get('/ormawa/profile', [OrmawaController::class, 'profile'])->name('ormawa.profile');
    Route::patch('/ormawa/profile', [OrmawaController::class, 'updateProfile'])->name('ormawa.profile.update');
    
    // Riwayat Kegiatan Ormawa
    Route::get('/ormawa/history', [OrmawaController::class, 'history'])->name('ormawa.history');
    
    // Statistik Ormawa
    Route::get('/ormawa/statistics', [OrmawaController::class, 'statistics'])->name('ormawa.statistics');
    
    // Panduan & Bantuan
    Route::get('/ormawa/guide', [OrmawaController::class, 'guide'])->name('ormawa.guide');
});

});

require __DIR__.'/auth.php';