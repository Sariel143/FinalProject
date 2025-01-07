<?php
use App\Http\Controllers\SingleToolController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CipherController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CaesarCipherController;
use App\Http\Controllers\VigenereCipherController;
use App\Http\Controllers\PlayfairCipherController;
use App\Http\Controllers\ColumnarController;

Route::get('/', function () {
    return view('index');
});

Route::get('/aes-tool', [CipherController::class, 'index'])->name('aes-tool');
Route::post('/aes-tool', [CipherController::class, 'process']);

Route::get('/double-tool', function () {
    return view('double-tool');
})->name('double-tool.form');

Route::post('/double-tool/process', [ColumnarController::class, 'process'])->name('double-tool.process');

Route::get('/playfair-tool', function () {
    return view('playfair-tool');
})->name('playfair-tool.form');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/index', function () {
    return view('index');
})->name('index');

Route::get('/single-tool', function () {
    return view('single-tool');
})->name('single-tool.form');

Route::post('/single-tool/process', [SingleToolController::class, 'process'])->name('single-tool.process');

Route::get('/vigenere-cipher', function () {
    return view('vigenere-cipher');
})->name('vigenere-cipher.form');

Route::post('/vigenere-cipher/process', [VigenereCipherController::class, 'processCipher'])->name('vigenere-cipher.process');

Route::get('caesar-cipher', [CaesarCipherController::class, 'showForm'])->name('caesar-cipher.form');
Route::post('caesar-cipher', [CaesarCipherController::class, 'processForm'])->name('caesar-cipher.process');

Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact-us');

Route::post('/contact-us/submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
