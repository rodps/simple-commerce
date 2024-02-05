<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Services\ProductService;

class UpdateProductController extends Controller
{
    public function __construct(private ProductService $service)
    {
        $this->middleware('auth:api');
    }

    public function __invoke(int $id, UpdateProductRequest $request)
    {
        $response = $this->service->update($request->user()->id, $id, $request->validated());

        return response()->json($response);
    }
}
