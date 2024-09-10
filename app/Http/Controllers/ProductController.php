<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
/*use Illuminate\Support\Facades\Redirect;*/
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')->whereBelongsTo($request->user())->orderBy('id', 'asc')->get();
        $categories = Category::all();

        /*dd($categories);*/

        return Inertia::render('Product/Index', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = Product::where('user_id', $request->user()->id)->where('id', $id)->first();

        if (! $product) {
            abort(404);
        }

        $product->update($request->validated());

        /*return Redirect::route('products.index');*/
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $product = Product::where('user_id', $request->user()->id)->where('id', $id)->first();

        if (! $product) {
            abort(404);
        }

        $product->delete();

        return back()->with('message', 'Product deleted successfully.')->with('timestamps', now());
    }
}
