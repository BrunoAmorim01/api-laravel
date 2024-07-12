<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,

    ) {
        // Constructor logic here
    }

    public function create($data)
    {
        $product = $this->productRepository->create([
            'name' => $data["name"],
            'sku' => $data["sku"],
            'price' => $data["price"],
            'stock' => $data["stock"],
            'user_id'=> Auth::id()
        ]);

        return [
            'id' => $product['id'],
            'name' => $product['name'],
        ];
    }

}
