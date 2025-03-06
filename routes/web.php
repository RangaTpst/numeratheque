<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard utilisateur (accessible uniquement aux utilisateurs connectés et vérifiés)
Route::get('/dashboard', function () {
    $user = Auth::user();
    $loans = $user->loans()
        ->where(function ($query) {
            $query->whereNull('return_date')
                  ->orWhere('return_date', '>=', Carbon::now());
        })
        ->with('book')
        ->get();

    return view('dashboard', compact('user', 'loans'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes pour la gestion du profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes pour le CRUD des livres, catégories et emprunts
Route::middleware('auth')->group(function () {
    // Livres
    Route::resource('books', BookController::class);
    Route::get('/catalogue', [BookController::class, 'list'])->name('books.list');
    Route::post('/books/{book}/borrow', [LoanController::class, 'borrow'])->name('books.borrow');

    // Catégories
    Route::resource('categories', CategoryController::class);

    // Emprunts
    Route::resource('loans', LoanController::class);
});

// Espace Admin protégé par le middleware IsAdmin
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';
