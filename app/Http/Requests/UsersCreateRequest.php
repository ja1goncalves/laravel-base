<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersCreateRequest extends FormRequest
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
          'name' => 'required|string|min:5|max:120',
          'email' => 'required|string|email|max:150|unique:users,email,client,role,deleted_at,NULL',
          'password' => 'required|string|min:8|confirmed',
          'status' => 'required|integer',
          'role' => 'sometimes|string|min:5|max:50'
        ];
    }
}
