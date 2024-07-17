<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\ProductUpdate;
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
            'user_id' => Auth::id()
        ]);

        return [
            'id' => $product['id'],
            'name' => $product['name'],
        ];
    }

    public function index(int $perPage, int $page)
    {
        $products = $this->productRepository->index($perPage, $page);

        foreach ($products['data'] as $product) {
            if (is_object($product)) {
                $product->price /= 100;
            }
        }

        return $products;
    }

    public function find(string $id)
    {
        $product = $this->productRepository->find($id);

        if (is_object($product)) {
            $product->price /= 100;
        }

        return $product;
    }

    public function update($id, $data)
    {

        $product = new ProductUpdate();
        $product->id = $id;
        $product->name = $data['name'];
        $product->sku = $data['sku'];
        $product->price = $data['price'];


        $this->productRepository->update($product);
    }

}
