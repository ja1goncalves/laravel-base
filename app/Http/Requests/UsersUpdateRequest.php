<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateRequest extends FormRequest
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
          'id' => 'required|numeric|exists:users,id',
          'name' => 'sometimes|string|min:5|max:120',
          'email' => 'sometimes|string|email|max:150',
          'password' => 'sometimes|string|min:8|confirmed',
          'status'  => 'sometimes|integer',
          'role' => 'sometimes|string|min:5|max:50'
        ];
    }
}
