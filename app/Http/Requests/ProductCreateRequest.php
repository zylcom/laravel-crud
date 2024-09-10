<?php

namespace App\Http\Requests;

use App\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductCreateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:1'],
            'description' => ['string', 'nullable'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', Rule::enum(ProductStatus::class)],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }
}
