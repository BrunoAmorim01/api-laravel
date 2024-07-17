<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProducRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Validator;

class ProductsController extends Controller
{
    public function __construct(private ProductService $productService)
    {

    }

    public function create(CreateProducRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $response = $this->productService->create($data);

        return response()->json($response, 201);
    }

    public function index(Request $request)
    {
        $perPage = $request->query('perPage', 10);
        $page = $request->query('page', 1);

        $response = $this->productService->index((int) $perPage, (int) $page);

        return response()->json($response);
    }

    public function show(string $id)
    {
        $rules = [
            'id' => 'required|uuid|exists:products,id'
        ];

        Validator::validate([
            'id' => $id,
        ], $rules);


        $response = $this->productService->find($id);

        return response()->json($response);
    }

    public function update(string $id, UpdateProductRequest $request)
    {
        $data = [
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
        ];

        $this->productService->update($id, $data);

        return response(null, 204);
    }
}
