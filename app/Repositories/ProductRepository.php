<?php

namespace App\Repositories;

use App\Models\Product;




class ProductRepository
{
    public function create($data)
    {
        $product = Product::create($data);
        return $product->only(['id', 'name']);
    }

    public function increments(string $id, int $value)
    {
        Product::where('id', $id)->increment('stock', $value);
    }
}
