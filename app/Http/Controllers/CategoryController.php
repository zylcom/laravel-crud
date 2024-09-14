<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'asc')->get();

        return Inertia::render('Category/Index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return Redirect::route('categories.index')->with('message', 'Category created successfully.')->with('timestamps', now());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with(['products' => ['category']])->where('id', $id)->first();

        if (! $category) {
            abort(404);
        }

        $categories = Category::all();

        return Inertia::render('Category/Detail', ['category' => $category, 'categories' => $categories]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::where('id', $id)->first();

        if (! $category) {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return back()->with('message', 'Category updated successfully.')->with('timestamps', now());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $category = Category::where('id', $id)->first();

        if (! $category) {
            abort(404);
        }

        $category->delete();
        $redirect_to = $request->query('redirect_to');

        if ($redirect_to) {
            return Redirect::route($redirect_to)->with('message', 'Category deleted successfully.')->with('timestamps', now());
        }

        return back()->with('message', 'Category deleted successfully.')->with('timestamps', now());
    }
}
