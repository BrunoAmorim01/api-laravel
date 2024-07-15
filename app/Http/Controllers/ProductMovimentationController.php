<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProducMovimentationRequest;
use App\Services\CreateProductMovementData;
use App\Services\ProductMovimentationService;
use Auth;

class ProductMovimentationController extends Controller
{
    public function __construct(private ProductMovimentationService $productMovimentationService)
    {
    }

    public function create(CreateProducMovimentationRequest $request)
    {
        $data = $request->validated();
        $dataObj = new CreateProductMovementData();
        $dataObj->productId = $data['productId'];
        $dataObj->userId = Auth::id();
        $dataObj->quantity = $data['quantity'];
        $dataObj->type = $data['type'];
        $dataObj->reason = $data['reason'];
        $dataObj->proof = $data['proof'];

        $productMovimentation = $this->productMovimentationService->create($dataObj);
        return response()->json($productMovimentation, 201);
    }
}
