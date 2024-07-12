<?php

namespace App\Repositories;

use App\Models\Product;


interface ProductInterface
{
    public function getId(): string;
    public function getName(): string;
}

class ProductRepository
{
    public function create($data)
    {
        $product = Product::create($data);
        return $product->only(['id', 'name']);
    }
}
