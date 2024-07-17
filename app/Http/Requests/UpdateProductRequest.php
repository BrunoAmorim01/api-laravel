<?php

namespace App\Http\Requests;

use App\Repositories\ProductRepository;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateProductRequest extends FormRequest
{

    public function __construct(private ProductRepository $productRepository)
    {


    }
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
            "name" => "string",
            "sku" => "string|unique:products,sku," . $this->route('id'),
            "price" => "integer",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->route('id');

            $product = $this->productRepository->find($id);

            if (!$product) {
                $validator->errors()->add('product', 'Invalid product ID');
            }
        });
    }
}
