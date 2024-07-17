<?php

namespace App\Http\Controllers;


use App\Services\external\CepService;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function __construct(private CepService $cepService)
    {
    }

    public function getCep(string $zipcode)
    {
        $address = $this->cepService->getAddressFromCep($zipcode);

        return response()->json($address);
    }
}
