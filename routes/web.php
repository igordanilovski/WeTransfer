<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index']);
    Route::get('/logout', [AdminDashboardController::class, 'logout']);
});

Route::get('upload', [FileUploadController::class, 'create'])->name('upload');
Route::get('link/{slug}', [LinkController::class, 'findBySlug']);
Route::get('download/{slug}', [LinkController::class, 'download']);


Route::post('upload', [FileUploadController::class, 'store'])->name('store');

require __DIR__ . '/auth.php';
