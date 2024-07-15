<?php

namespace App\Services;

use App\Repositories\ProductMovementData;
use App\Repositories\ProductMovimentationDataResponse;
use App\Repositories\ProductMovimentationRepository;



class ProductMovimentationService
{
    public function __construct(
        private ProductMovimentationRepository $productMovimentationRepository,

    ) {
    }

    public function create(ProductMovementData $data): ProductMovimentationDataResponse
    {

        $productMovement = $this->productMovimentationRepository->create($data);

        return $productMovement;

    }

}
