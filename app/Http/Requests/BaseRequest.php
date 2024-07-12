<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            "code" => 1,
            'message' => 'The given data was invalid',
            'errors' => $validator->errors()
        ], 400);

        //$response = response()

        throw new HttpResponseException($response);
    }
}
