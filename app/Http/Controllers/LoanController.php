<?php

namespace App\Http\Controllers;

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

        Loan::create($request->all());

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
}
