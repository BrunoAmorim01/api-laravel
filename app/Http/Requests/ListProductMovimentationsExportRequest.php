<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ListProductMovimentationsExportRequest extends FormRequest
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
            'type' => 'string|in:in,out',
            'reason' => 'string|in:sell,buy,adjustment,transfer',
            'productId' => 'uuid|exists:products,id',
            'dateFrom' => 'date_format:Y-m-d',
            'dateTo' => 'date_format:Y-m-d|after_or_equal:dateFrom',
        ];
    }
}
