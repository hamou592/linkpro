<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\PublicClientController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('clients', ClientController::class);
    Route::resource('contents', ContentController::class);
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';

// Must be LAST
Route::get('/{clientName}', [PublicClientController::class,'show'])
    ->where('clientName', '^(?!admin|login|register|dashboard|clients|contents).*$');
