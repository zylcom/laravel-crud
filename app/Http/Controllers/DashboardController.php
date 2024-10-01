<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $products = [];
        $users = [];

        $response = Gate::inspect('viewAll', Product::class);

        if ($response->allowed()) {
            $users = User::with('products')->where('id', '!=', $request->user()->id)->orderBy('id', 'asc')->take(10)->get();
            $products = Product::with('category')->whereBelongsTo($request->user())->where('stock', '<=', '30')->orderBy('stock', 'asc')->get();
        } else {
            $products = Product::with('category')->whereBelongsTo($request->user())->where('stock', '<=', '30')->orderBy('stock', 'asc')->get();
        }

        /*dd($request->user()->notifications);*/

        $categories = Category::all();

        return Inertia::render('Dashboard', [
            'categories' => $categories,
            'products' => $products,
            'users' => $users
        ]);
    }
}
