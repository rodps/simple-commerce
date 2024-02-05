<?php

namespace App\Http\Services;

use App\Models\Product;

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
}