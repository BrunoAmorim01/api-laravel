<?php

namespace App\Http\Requests;

use Auth;

class CreateProducMovimentationRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'productId' => 'required|string|exists:products,id',
            'quantity' => 'required|numeric',
            'type' => 'required|in:in,out',
            'reason' => 'required|in:sell,buy,adjustment,transfer',
            'proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }
}
