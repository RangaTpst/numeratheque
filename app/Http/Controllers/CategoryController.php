<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée avec succès.');
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $this->authorizeAdmin();
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeAdmin();
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }

    protected function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs.');
        }
    }
}
