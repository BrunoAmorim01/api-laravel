<?php

namespace App\Repositories;

use App\Models\ProductMovimentation;
use Log;

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

class ProductMovimentationIndexRequest
{
    public string|null $productId;
    public string|null $userId;
    public string|null $type;
    public string|null $reason;
    public string|null $dateFrom;
    public string|null $dateTo;
    public int|null $page;
    public int|null $perPage;
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

    public function index(ProductMovimentationIndexRequest $filters)
    {
        $productMovimentations = ProductMovimentation
            ::with(['product:id,name', 'user:id,name'])
            ->select(['id', 'user_id', 'product_id', 'type', 'quantity', 'reason', 'proof', 'created_at']);

        if ($filters->productId) {
            $productMovimentations->where('product_id', $filters->productId);
        }

        if ($filters->userId) {
            $productMovimentations->where('user_id', $filters->userId);
        }

        if ($filters->type) {
            $productMovimentations->where('type', $filters->type);
        }

        if ($filters->reason) {
            $productMovimentations->where('reason', $filters->reason);
        }

        if ($filters->dateFrom) {
            $productMovimentations->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime($filters->dateFrom)));
        }

        if ($filters->dateTo) {
            $productMovimentations->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($filters->dateTo)));
        }

        if (isset($filters->perPage, $filters->page)) {
            Log::info('Paginate');
            return $productMovimentations->paginate($filters->perPage, ['*'], 'page', $filters->page);
        }

        $productMovimentations = $productMovimentations->get();

        return $productMovimentations;
    }
}
