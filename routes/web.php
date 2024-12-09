<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CipherController;

Route::get('/', function () {
    return view('aes-tool'); // Replace 'aes-tool' with the name of your Blade file (without the .blade.php extension)
});
Route::get('/aes-tool', [CipherController::class, 'index'])->name('aes-tool');
Route::post('/aes-tool', [CipherController::class, 'process']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
