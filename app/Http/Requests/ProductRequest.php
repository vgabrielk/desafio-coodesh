<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string',
            'imported_t' => 'required|date',
            'url' => 'required|string',
            'creator' => 'required|string',
            'created_t' => 'required|date',
            'last_modified_t' => 'required|string',
            'product_name' => 'required|string',
            'quantity' => 'required|string',
            'brands' => 'required|string',
            'categories' => 'required|string',
            'labels' => 'required|string',
            'cities' => 'nullable|string',
            'purchase_places' => 'nullable|string',
            'stores' => 'nullable|string',
            'ingredients_text' => 'nullable|string',
            'traces' => 'nullable|string',
            'serving_size' => 'nullable|string',
            'serving_quantity' => 'nullable|integer',
            'nutriscore_score' => 'nullable|integer',
            'nutriscore_grade' => 'nullable|string|max:2',
            'main_category' => 'nullable|string',
            'image_url' => 'nullable|string|url',
        ];
    }
}
