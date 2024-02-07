<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ShowProductController extends Controller
{

    public function __invoke(Product $product)
    {
        return response()->json($product);
    }
}
