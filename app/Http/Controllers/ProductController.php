<?php

namespace App\Http\Controllers;

use App\Events\ProductDeleted;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = [];

        $response = Gate::inspect('viewAll', Product::class);

        if ($response->allowed()) {
            $products = Product::with('category', 'user')->orderBy('id', 'asc')->get();
        } else {
            $products = Product::with('category')->whereBelongsTo($request->user())->orderBy('id', 'asc')->get();
        }

        $categories = Category::all();

        return Inertia::render('Product/Index', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = Category::all();

        return Inertia::render('Product/Create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request)
    {
        Gate::authorize('create', Product::class);

        $product = $request->validated();
        $request->user()->products()->create($product);

        return Redirect::route('products.index')->with('message', 'Product created successfully.')->with('timestamps', now());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $product = Product::with('category', 'user')->where('id', $id)->first();
        $categories = Category::all();

        if (! $product) {
            abort(404);
        }

        Gate::authorize('view', $product);

        return Inertia::render('Product/Detail', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = Product::where('id', $id)->first();

        if (! $product) {
            abort(404);
        }

        Gate::authorize('update', $product);

        $product->update($request->validated());

        return back()->with('message', 'Product updated successfully.')->with('timestamps', now());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $product = Product::with('user')->where('id', $id)->first();

        if (! $product) {
            abort(404);
        }

        Gate::authorize('delete', $product);

        if ($product->user_id !== $request->user()->id && $request->user()->role === UserRole::Admin) {
            ProductDeleted::dispatch($product);
        }

        $product->delete();
        $redirect_to = $request->query('redirect_to');

        if ($redirect_to) {
            return Redirect::route($redirect_to)->with('message', 'Product deleted successfully.')->with('timestamps', now());
        }

        return back()->with('message', 'Product deleted successfully.')->with('timestamps', now());
    }
}
