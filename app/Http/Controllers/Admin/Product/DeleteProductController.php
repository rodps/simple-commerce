<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DeleteProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:delete,product');
    }

    public function __invoke(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
