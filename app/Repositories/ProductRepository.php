<?php

namespace App\Repositories;

use App\Models\Product;

class ProductIndexResponse
{
    public string $id;
    public string $name;
    public int $stock;
    public int $price;
    public string $sku;
}

class ProductUpdate
{
    public string $id;
    public string $name;
    public string $sku;
    public int $price;
}




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
        return Product::find($id, ['id', 'name', 'stock', 'price', 'sku']);
    }
    public function index(int $perPage = 10, int $page = 1)
    {
        $products = Product::select(['id', 'name', 'stock', 'price', 'sku'])
            ->paginate(
                $perPage,
                ['*'],
                'page',
                $page
            );

        $response = [];
        foreach ($products as $product) {
            $productResponse = new ProductIndexResponse();
            $productResponse->id = $product->id;
            $productResponse->name = $product->name;
            $productResponse->stock = $product->stock;
            $productResponse->price = $product->price;
            $productResponse->sku = $product->sku;

            $response[] = $productResponse;
        }

        return [
            'data' => $response,
            'pagination' => [
                'total' => $products->total(),
                'perPage' => $products->perPage(),
                'currentPage' => $products->currentPage(),
                'lastPage' => $products->lastPage(),
            ],
        ];
    }

    public function update(ProductUpdate $data)
    {
        $toUpdate = [];

        if ($data->name) {
            $toUpdate['name'] = $data->name;
        }

        if ($data->sku) {
            $toUpdate['sku'] = $data->sku;
        }

        if ($data->price) {
            $toUpdate['price'] = $data->price;
        }

        if ($data->sku) {
            $toUpdate['sku'] = $data->sku;
        }


        Product::where('id', $data->id)->update($toUpdate);
    }
}
