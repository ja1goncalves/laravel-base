<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModulesUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name' => 'sometimes|string|max:100',
          'icon' => 'sometimes|string|max:100',
          'route' => 'sometimes|string|max:100',
          'status' => 'sometimes|boolean'
        ];
    }
}
