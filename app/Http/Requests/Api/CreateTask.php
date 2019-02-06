<?php

namespace App\Http\Requests\Api;

class CreateTask extends ApiRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->get('task') ? : [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fecha' => 'required|date|date_format:Y-m-d',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'longitud' => 'required',
            'latitud' => 'required',
            'mercancia' => 'required|numeric',
            'estado' => 'required|string|max:20'
        ];
    }
}