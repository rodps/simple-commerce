<?php

namespace App\Http\Services;

use App\Models\Product;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
    public function create(int $userId, array $data)
    {
        return Product::create([
            'user_id' => $userId,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $data['image']
        ]);
    }

    public function update(int $userId, int $id, array $data)
    {
        $product = Product::where('id', $id)->where('user_id', $userId)->first();

        if (!$product) {
            throw new NotFoundHttpException('Product ' . $id . ' not found');
        }

        $product->update($data);

        return $product;
    }
}