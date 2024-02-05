<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DeleteProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:delete,product');
    }

    public function __invoke(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
