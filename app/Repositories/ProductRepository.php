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

    public function decrements(string $id, int $value)
    {
        Product::where('id', $id)->decrement('stock', $value);
    }

    public function find(string $id)
    {
        return Product::find($id, ['id', 'name', 'stock']);
    }
}
