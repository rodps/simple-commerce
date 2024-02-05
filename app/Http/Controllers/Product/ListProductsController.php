<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ListProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        $perPage = $request->query('limit', 10);

        $products = Product::query();
        
        if ($name = $request->query('name')) {
            $products = Product::where('name', 'like', "%{$name}%");
        }
        if ($max_price = $request->query('max_price')) {
            $products = Product::where('price', '<=', $max_price);
        }
        if ($min_price = $request->query('min_price')) {
            $products = Product::where('price', '>=', $min_price);
        }
        
        $products = $products->paginate($perPage);

        return response()->json($products);
    }
}
