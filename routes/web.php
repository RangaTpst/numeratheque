<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;
use Carbon\Carbon;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Category;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;

// Accueil
Route::get('/', function () {
    $category = Category::has('books')->inRandomOrder()->first();
    $books = $category ? $category->books()->inRandomOrder()->take(4)->get() : collect();

    return view('welcome', compact('category', 'books'));
})->name('welcome');


// Tableau de bord utilisateur
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Tous les emprunts encore en base (pas supprimés = actifs)
    $loans = $user->loans()->where('returned', false)->with('book')->get();

    // Statistiques
    $totalBooks = Book::count();
    $borrowedBooks = Loan::where('returned', false)->count();
    $availableBooks = $totalBooks - $borrowedBooks;

    $mostUsedCategory = Category::withCount('books')
        ->orderByDesc('books_count')
        ->first();

    // Pas d'emprunts rendus enregistrés (dans ton système actuel)
    $recentReturns = $user->loans()
    ->where('returned', true)
    ->latest('return_date')
    ->take(3)
    ->with('book')
    ->get();


    return view('dashboard', compact(
        'loans',
        'totalBooks',
        'borrowedBooks',
        'availableBooks',
        'mostUsedCategory',
        'recentReturns'
    ));
})->middleware(['auth'])->name('dashboard');


// Gestion du profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Gestion des livres, catégories et emprunts
Route::middleware('auth')->group(function () {
    // Livres
    Route::resource('books', BookController::class);
    Route::get('/catalogue', [BookController::class, 'list'])->name('books.list');
    Route::post('/books/{book}/borrow', [LoanController::class, 'borrow'])->name('books.borrow');

    // Catégories
    Route::resource('categories', CategoryController::class);

    // Emprunts
    Route::resource('loans', LoanController::class);

    // Marquer un prêt comme retourné (admin uniquement)
    Route::patch('/admin/loans/{loan}/return', [LoanController::class, 'markAsReturned'])
        ->name('admin.loans.return')
        ->middleware(IsAdmin::class);
});


// Espace administrateur
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';
