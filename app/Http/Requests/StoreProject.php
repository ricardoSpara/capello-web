<?php

namespace Capello\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProject extends FormRequest
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
            'title' => 'required|max:30',
            'started_date' => 'required',
            'courses' => 'required',
            'users' => 'required',
            'tags' => 'required',
        ];
    }

    /**
     * Get attribute name
     *
     * @return array
     */
    public function attribute()
    {
        return [
            'title' => 'título',
            'started_date' => 'data de ínicio',
            'courses' => 'cursos',
            'users' => 'usuários',
            'tags' => 'tags',
        ];
    }
}
