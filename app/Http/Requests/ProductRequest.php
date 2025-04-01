<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => [
                'required',
                'numeric',
                'min:' . ($this->cost * 1.1),
                function ($attribute, $value, $fail) {
                    if ($value < ($this->cost * 1.1)) {
                        $fail('O preço de venda deve ser pelo menos 10% maior que o custo.');
                    }
                }
            ],
            'cost' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpg,png|max:2048'
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $description = $this->input('description');
            $cleaned = strip_tags($description, '<p><br><b><strong>');

            if ($cleaned !== $description) {
                $validator->errors()->add('description', 'Apenas as tags <p>, <br>, <b> e <strong> são permitidas.');
            }
        });
    }
}
