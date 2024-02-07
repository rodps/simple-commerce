<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;

class UpdateProductController extends Controller
{
    public function __invoke(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return response()->json($product);
    }
}
