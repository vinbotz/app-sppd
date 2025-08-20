<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

// Test Route untuk Popup
Route::get('/test-popup', function () {
    return view('test-popup');
})->name('test.popup');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Admin Dashboard (khusus admin)
// Route::middleware([\App\Http\Middleware\CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

// Supervisor Dashboard (khusus supervisor)
Route::middleware([\App\Http\Middleware\CheckRole::class . ':supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Supervisor\DashboardController::class, 'index'])->name('dashboard');
    Route::get('sppd/{id}', [\App\Http\Controllers\Supervisor\DashboardController::class, 'show'])->name('sppd.show');
    Route::get('pengajuan', [\App\Http\Controllers\Supervisor\DashboardController::class, 'indexPengajuan'])->name('pengajuan.index');
    Route::get('riwayat', [\App\Http\Controllers\Supervisor\DashboardController::class, 'indexPengajuan'])->name('sppd.riwayat'); // Tambahan untuk redirect riwayat
    Route::get('sppd/export-pdf', [\App\Http\Controllers\Admin\DashboardController::class, 'exportPdf'])->name('sppd.exportPdf');
    Route::get('sppd/export-excel', [\App\Http\Controllers\Admin\DashboardController::class, 'exportExcel'])->name('sppd.exportExcel');
    Route::post('sppd/{id}/approve', [\App\Http\Controllers\Supervisor\DashboardController::class, 'approve'])->name('sppd.approve');
    Route::post('sppd/{id}/reject', [\App\Http\Controllers\Supervisor\DashboardController::class, 'reject'])->name('sppd.reject');
    Route::post('sppd/{id}/update-approval', [\App\Http\Controllers\Supervisor\DashboardController::class, 'updateApproval'])->name('sppd.updateApproval');
    // Route lain khusus supervisor jika ada
});

// Admin Routes (khusus admin)
Route::middleware([\App\Http\Middleware\CheckRole::class . ':admin'])
    ->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('sppd', \App\Http\Controllers\Admin\SppdController::class);
    Route::get('sppd-status', [\App\Http\Controllers\Admin\SppdController::class, 'status'])->name('sppd.status');
    // Route::get('sppd/export-pdf', [DashboardController::class, 'exportPdf'])->name('sppd.exportPdf');
    // Route::get('sppd/export-excel', [DashboardController::class, 'exportExcel'])->name('sppd.exportExcel');
    Route::post('sppd/export-pdf', [DashboardController::class, 'exportPdf'])->name('sppd.exportPdf');
    Route::post('sppd/export-excel', [DashboardController::class, 'exportExcel'])->name('sppd.exportExcel');
    Route::resource('users', UserController::class);
    Route::get('sppd/{id}', [\App\Http\Controllers\Admin\SppdController::class, 'show'])->name('sppd.show');
    Route::post('sppd/{sppd}/approve', [\App\Http\Controllers\Admin\SppdController::class, 'approve'])->name('sppd.approve');
    Route::post('sppd/{sppd}/reject', [\App\Http\Controllers\Admin\SppdController::class, 'reject'])->name('sppd.reject');
    Route::put('sppd/{id}/update-approval', [\App\Http\Controllers\Admin\SppdController::class, 'updateApproval'])->name('sppd.updateApproval');
    Route::patch('sppd/{id}/update-status', [\App\Http\Controllers\Admin\SppdController::class, 'updateStatus'])->name('sppd.updateStatus');
    Route::get('dashboard/export-pdf', [DashboardController::class, 'exportPdf'])->name('dashboard.exportPdf');
    Route::get('dashboard/export-excel', [DashboardController::class, 'exportExcel'])->name('dashboard.exportExcel');
});

// Protected Routes for Logged-in Users
Route::middleware(['auth'])->group(function () {
    // Route::resource('sppd', SppdController::class); // Dihapus agar tidak bentrok
    // Route::get('sppd/{sppd}/export', [SppdController::class, 'export'])
    //     ->name('sppd.export')
    //     ->middleware('role:supervisor');

    Route::get('admin/riwayat-pengajuan', [\App\Http\Controllers\Admin\SppdController::class, 'riwayat'])->name('admin.sppd.riwayat');
    Route::post('/notifications/mark-read', [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.mark-read');
    Route::post('/notifications/clear', [\App\Http\Controllers\NotificationController::class, 'clear'])->name('notifications.clear');
   
});
