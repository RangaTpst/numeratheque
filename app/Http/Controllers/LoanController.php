<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $users = User::all();
        $books = Book::all();
        return view('loans.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
        ]);

        Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'loan_date' => $request->loan_date,
            'return_date' => $request->return_date,
        ]);
        

        return redirect()->route('loans.index')->with('success', 'Emprunt ajouté avec succès.');
    }

    public function show(Loan $loan)
    {
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $this->authorizeAdmin();
        $users = User::all();
        $books = Book::all();
        return view('loans.edit', compact('loan', 'users', 'books'));
    }

    public function update(Request $request, Loan $loan)
    {
        $this->authorizeAdmin();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
        ]);

        $loan->update($request->all());

        return redirect()->route('loans.index')->with('success', 'Emprunt mis à jour avec succès.');
    }

    public function destroy(Loan $loan)
    {
        $this->authorizeAdmin();
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Emprunt supprimé avec succès.');
    }

    protected function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs.');
        }
    }

    public function borrow(Request $request, Book $book)
{
    $loanDate = Carbon::now();

    // Si l'utilisateur ne fournit pas de date, on ajoute 2 semaines
    $returnDate = $request->input('return_date')
        ? Carbon::parse($request->input('return_date'))
        : $loanDate->copy()->addWeeks(2);

    // Vérification de la limite d'un mois
    if ($returnDate->greaterThan($loanDate->copy()->addMonth())) {
        return redirect()->back()->with('error', 'La date de retour dépasse le délai maximal d\'un mois.');
    }

    Loan::create([
        'user_id' => Auth::id(),
        'book_id' => $book->id,
        'loan_date' => $loanDate,
        'return_date' => $returnDate,
    ]);

    return redirect()
        ->route('books.show', $book)
        ->with('success', 'Livre emprunté avec succès jusqu\'au ' . $returnDate->format('d/m/Y') . '.');
}


}
