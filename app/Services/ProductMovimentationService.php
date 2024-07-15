<?php

namespace App\Services;

use App\Repositories\ProductMovementData;
use App\Repositories\ProductMovimentationDataResponse;
use App\Repositories\ProductMovimentationRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateProductMovementData
{
    public string $productId;
    public string $userId;
    public int $quantity;
    public string $type;
    public string $reason;
    public UploadedFile $proof;

}


class ProductMovimentationService
{
    public function __construct(
        private ProductMovimentationRepository $productMovimentationRepository,

    ) {
    }

    public function create(CreateProductMovementData $data): ProductMovimentationDataResponse
    {
        $filename = Str::uuid() . '.' . $data->proof->getClientOriginalExtension();
        $result = $data->proof->storeAs('docs', $filename, 's3');
        $fileResponse = Storage::url($result);

        $productMovimentationToCreate = new ProductMovementData();
        $productMovimentationToCreate->productId = $data->productId;
        $productMovimentationToCreate->userId = $data->userId;
        $productMovimentationToCreate->quantity = $data->quantity;
        $productMovimentationToCreate->type = $data->type;
        $productMovimentationToCreate->reason = $data->reason;
        $productMovimentationToCreate->proof = $fileResponse;

        $productMovement = $this->productMovimentationRepository->create($productMovimentationToCreate);

        return $productMovement;

    }

}
