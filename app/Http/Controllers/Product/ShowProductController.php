<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ShowProductController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function __invoke(Product $product)
    {
        return response()->json($product);
    }
}
