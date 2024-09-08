<?php

namespace App\Http\Controllers;

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
        $products = Product::whereBelongsTo($request->user())->where('stock', '<=', '30')->get();

        return Inertia::render('Dashboard', [
            'products' => $products,
        ]);
    }
}
