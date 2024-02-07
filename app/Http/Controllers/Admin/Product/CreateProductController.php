<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;

class CreateProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function __invoke(CreateProductRequest $request)
    {        
        $response = $this->service->create($request->user()->id, $request->validated());

        return response()->json($response, 201);
    }
}
