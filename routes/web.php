<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

// =================== Public ===================
Route::view('/', 'welcome');

// Auth
Route::get('/register', [RegisterController::class, 'show'])->name('register.form');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'show'])->name('login.form');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =================== OAuth (Drive) ===================
// Lấy refresh_token một lần rồi thôi; GIỮ LẠI 2 route này nếu còn cần.
Route::get('/drive/auth', function () {
    $client = new \Google\Client();
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
    $client->setAccessType('offline');
    $client->setPrompt('consent select_account');
    $client->addScope(\Google\Service\Drive::DRIVE);

    return redirect($client->createAuthUrl());
})->name('drive.auth');

Route::get('/drive/callback', function (\Illuminate\Http\Request $request) {
    if (!$request->has('code')) return 'Missing code';

    $client = new \Google\Client();
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

    $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));
    if (empty($token['refresh_token'])) {
        return 'Không thấy refresh_token. Vào /drive/auth lại (hoặc thu hồi quyền app và thử lại).';
    }
    return 'OK! Refresh token: ' . $token['refresh_token'];
})->name('drive.callback');

// =================== Admin ===================
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/', fn() => redirect()->route('admin.dashboard'));

    Route::get('/documents', [App\Http\Controllers\Admin\DocumentManagementController::class, 'index'])->name('documents.index');
    Route::post('/documents/{id}/approve', [App\Http\Controllers\Admin\DocumentManagementController::class, 'approve'])->name('documents.approve');
    Route::post('/documents/{id}/reject', [App\Http\Controllers\Admin\DocumentManagementController::class, 'reject'])->name('documents.reject');
    Route::delete('/documents/{id}', [App\Http\Controllers\Admin\DocumentManagementController::class, 'destroy'])->name('documents.destroy');

    // Route Quản lý User
    Route::get('/users', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/role', [App\Http\Controllers\Admin\UserManagementController::class, 'updateRole'])->name('users.role');
    Route::post('/users/{id}/status', [App\Http\Controllers\Admin\UserManagementController::class, 'toggleStatus'])->name('users.status');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('users.destroy');
});

// =================== App (cần đăng nhập) ===================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    // Dùng resource để có đủ tên route, bao gồm documents.destroy
    // Route::resource('documents', DocumentController::class)
    //     ->only(['index', 'create', 'store', 'destroy']);
});

