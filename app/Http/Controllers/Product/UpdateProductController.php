<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;

class UpdateProductController extends Controller
{
    public function __construct(private ProductService $service)
    {
        $this->middleware('auth:api');
    }

    public function __invoke(UpdateProductRequest $request, Product $product)
    {
        $response = $this->service->update($product, $request->validated());

        return response()->json($response);
    }
}
