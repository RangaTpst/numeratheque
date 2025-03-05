<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Affiche la liste de tous les livres.
     */
    public function index()
    {
        $books = Book::with('category')->get();
        return view('books.index', compact('books'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau livre.
     */
    public function create()
    {
        $this->authorizeAdmin();
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau livre dans la base de données.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Livre ajouté avec succès.');
    }

    /**
     * Affiche le détail d'un livre spécifique.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Affiche le formulaire d'édition d'un livre existant.
     */
    public function edit(Book $book)
    {
        $this->authorizeAdmin();
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Met à jour un livre existant dans la base de données.
     */
    public function update(Request $request, Book $book)
    {
        $this->authorizeAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Livre mis à jour avec succès.');
    }

    /**
     * Supprime un livre de la base de données.
     */
    public function destroy(Book $book)
    {
        $this->authorizeAdmin();
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Livre supprimé avec succès.');
    }

    /**
     * Vérifie si l'utilisateur est administrateur.
     */
    protected function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs.');
        }
    }
}
