<?php

namespace App\Services;

use App\Exports\ProductMovimentationExport;
use App\Jobs\ProcessProductMovimentation;
use App\Repositories\ProductMovementData;
use App\Repositories\ProductMovimentationDataResponse;
use App\Repositories\ProductMovimentationIndexRequest;
use App\Repositories\ProductMovimentationRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateProductMovementData
{
    public string $productId;
    public string $userId;
    public int $quantity;
    public string $type;
    public string $reason;
    public UploadedFile $proof;

}
;

class ProductMovimentationService
{
    public function __construct(
        private ProductMovimentationRepository $productMovimentationRepository,
        private ProductRepository $productRepository,
    ) {
    }

    public function create(CreateProductMovementData $data): ProductMovimentationDataResponse
    {

        if ($data->type === 'out') {
            $product = $this->productRepository->find($data->productId);

            if ($product->stock < $data->quantity) {
                throw new BadRequestHttpException('Insufficient stock');
            }
        }

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

        ProcessProductMovimentation::dispatch(json_encode($productMovement));

        return $productMovement;

    }

    public function index(
        ProductMovimentationIndexRequest $data
    ): array {

        $responseIndex = $this->productMovimentationRepository->index($data);
        $items = $responseIndex->items();
        $dataCollection = collect($items);

        $dataMappet = $dataCollection->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => $item->type,
                'quantity' => $item->quantity,
                'reason' => $item->reason,
                'proof' => $item->proof,
                'createdAt' => $item->created_at,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                ],
                'user' => [
                    'id' => $item->user->id,
                    'name' => $item->user->name,
                ],
            ];

        });

        $response = [
            'data' => $dataMappet,
            'pagination' => [
                'total' => $responseIndex->total(),
                'perPage' => $responseIndex->perPage(),
                'currentPage' => $responseIndex->currentPage(),
                'lastPage' => $responseIndex->lastPage(),
            ],
        ];

        return $response;
    }

    public function export(
        ProductMovimentationIndexRequest $data
    ) {
        $responseIndex = $this->productMovimentationRepository->index($data);
        return new ProductMovimentationExport($responseIndex);

    }
}
