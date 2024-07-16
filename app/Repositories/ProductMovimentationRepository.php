<?php

namespace App\Repositories;

use App\Models\ProductMovimentation;

class ProductMovementData
{
    public string $productId;
    public string $userId;
    public int $quantity;
    public string $type;
    public string $reason;
    public string $proof;

}

class ProductMovimentationDataResponse
{
    public string $id;
}

class ProductMovimentationFindResponse
{
    public string $id;
    public string $type;
    public string $productId;
    public int $quantity;
}

class ProductMovimentationRepository
{
    public function create(ProductMovementData $data): ProductMovimentationDataResponse
    {

        $productMovimentation = ProductMovimentation::create([
            'product_id' => $data->productId,
            'user_id' => $data->userId,
            'quantity' => $data->quantity,
            'type' => $data->type,
            'reason' => $data->reason,
            'proof' => $data->proof
        ]);

        $productMovimentationCreated = $productMovimentation->only(['id']);

        $response = new ProductMovimentationDataResponse();
        $response->id = $productMovimentationCreated['id'];

        return $response;
    }

    public function find(string $id): ProductMovimentationFindResponse
    {
        $productMovimentation = ProductMovimentation::find($id, ['id', 'type', 'product_id', 'quantity']);

        $response = new ProductMovimentationFindResponse();
        $response->id = $productMovimentation->id;
        $response->type = $productMovimentation->type;
        $response->productId = $productMovimentation->product_id;
        $response->quantity = $productMovimentation->quantity;

        return $response;
    }
}
