<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListProductsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $priceMaxRules = ['nullable', 'numeric'];

        if ($this->filled('filter.price_min')) {
            $priceMaxRules[] = 'gte:filter.price_min';
        }

        return [
            'sort' => ['nullable', Rule::in(['newest', 'price_asc', 'price_desc', 'rating'])],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'between:1,100'],

            'filter' => ['nullable', 'array'],
            'filter.*' => ['nullable', 'string'],
            'filter.price_min' => ['nullable', 'numeric', 'min:0'],
            'filter.price_max' => $priceMaxRules,
            'filter.in_stock' => ['nullable', 'boolean'],
            'filter.on_sale' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'sort.in' => 'Sort must be one of: newest, price_asc, price_desc, rating.',

            'page.integer' => 'Page must be a whole number.',
            'page.min' => 'Page must be at least :min.',

            'per_page.integer' => 'Per page must be a whole number.',
            'per_page.between' => 'Per page must be between :min and :max.',

            'filter.array' => 'Filter must be a list like filter[brand]=yamaha.',
            'filter.*.string' => 'Each filter value must be text, for example filter[color]=black,white.',

            'filter.price_min.numeric' => 'Minimum price must be a number.',
            'filter.price_min.min' => 'Minimum price cannot be negative.',

            'filter.price_max.numeric' => 'Maximum price must be a number.',
            'filter.price_max.gte' => 'Maximum price cannot be lower than the minimum price.',

            'filter.in_stock.boolean' => 'In stock must be 1 or 0.',
            'filter.on_sale.boolean' => 'On sale must be 1 or 0.',
        ];
    }
}
