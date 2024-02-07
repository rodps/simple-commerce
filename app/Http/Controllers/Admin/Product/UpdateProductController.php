<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;

class UpdateProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function __invoke(UpdateProductRequest $request, Product $product)
    {
        $response = $this->service->update($product, $request->validated());

        return response()->json($response);
    }
}
