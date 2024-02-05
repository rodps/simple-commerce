<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Services\ProductService;

class CreateProductController extends Controller
{
    public function __construct(private ProductService $service) {
        $this->middleware('auth:api');
    }

    public function __invoke(CreateProductRequest $request)
    {
        $response = $this->service->create($request->user()->id, $request->validated());

        return response()->json($response, 201);
    }
}
