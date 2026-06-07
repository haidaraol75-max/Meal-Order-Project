<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string',
            'availability' => 'sometimes|boolean',
            'category_id' => [
                'sometimes',
                'nullable', 
                'exists:categories,id'
                 ],
         'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ];
    }
}
