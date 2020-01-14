<?php

namespace Capello\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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

        $id = auth()->user()->id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id.',id',
            'image' => 'nullable|mimes:jpeg,jpg,png,JPG',
            'cpf' => 'required|min:14|unique:users,cpf,'.$id.',id',
            'birth' => 'required|min:10',
            'gender' => 'required|min:1',
            'phone' => 'required|min:14',
        ];
    }
}
