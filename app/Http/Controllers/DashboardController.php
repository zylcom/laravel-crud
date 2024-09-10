<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $products = Product::with('category')->whereBelongsTo($request->user())->where('stock', '<=', '30')->orderBy('stock', 'asc')->get();
        $categories = Category::all();

        return Inertia::render('Dashboard', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
