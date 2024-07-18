<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProducMovimentationRequest;
use App\Http\Requests\ListProductMovimentationsExportRequest;
use App\Http\Requests\ListProductMovimentationsRequest;
use App\Repositories\ProductMovimentationIndexRequest;
use App\Services\CreateProductMovementData;
use App\Services\ProductMovimentationService;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

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

    public function index(ListProductMovimentationsRequest $request)
    {
        $dataValidated = $request->validated();

        $data = new ProductMovimentationIndexRequest();
        $data->productId = $dataValidated['productId'] ?? null;
        $data->userId = $dataValidated['userId'] ?? null;
        $data->type = $dataValidated['type'] ?? null;
        $data->reason = $dataValidated['reason'] ?? null;
        $data->page = $dataValidated['page'] ?? 1;
        $data->perPage = $dataValidated['limit'] ?? 10;
        $data->dateFrom = $dataValidated['dateFrom'] ?? null;
        $data->dateTo = $dataValidated['dateTo'] ?? null;


        $productMovimentations = $this->productMovimentationService->index(
            $data
        );
        return response()->json($productMovimentations);
    }

    public function export(ListProductMovimentationsExportRequest $request)
    {
        $dataValidated = $request->validated();

        $data = new ProductMovimentationIndexRequest();
        $data->productId = $dataValidated['productId'] ?? null;
        $data->userId = $dataValidated['userId'] ?? null;
        $data->type = $dataValidated['type'] ?? null;
        $data->reason = $dataValidated['reason'] ?? null;
        $data->dateFrom = $dataValidated['dateFrom'] ?? null;
        $data->dateTo = $dataValidated['dateTo'] ?? null;

        $response = $this->productMovimentationService->export($data);
        return Excel::download($response, 'movimentations.xlsx');
    }


}
