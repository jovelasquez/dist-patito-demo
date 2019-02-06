<?php

namespace App\Http\Requests\Api;

class CreateDistributor extends ApiRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->get('distributor') ? : [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required|string|max:50|alpha_num|unique:distributors',
            'email' => 'required|string|email|max:255|unique:distributors',
            'password' => 'required|string|max:20'
        ];
    }
}