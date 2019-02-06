<?php

namespace App\Http\Requests\Api;

class UpdateDistributor extends ApiRequest
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
            'login' => 'sometimes|max:50|alpha_num|unique:distributor,login,' . $this->user()->id,
            'email' => 'sometimes|email|max:255|unique:distributor,email,' . $this->user()->id,
            'password' => 'sometimes|min:6',
        ];
    }
}