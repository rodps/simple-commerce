<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{

    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }
}
