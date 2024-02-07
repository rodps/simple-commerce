<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;

class CreateProductController extends Controller
{
    public function __invoke(CreateProductRequest $request)
    {   
        $data = $request->validated();

        $product = Product::create([
            'user_id' => $request->user()->id,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $data['image']
        ]);     

        return response()->json($product, 201);
    }
}
