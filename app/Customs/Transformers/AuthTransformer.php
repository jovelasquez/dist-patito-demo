<?php

namespace App\Customs\Transformers;

class AuthTransformer extends Transformer
{
    protected $resourceName = 'auth';

    public function transform($data)
    {

        return [
            'login' => $data['login'],
            'token' => $data['token'],
        ];
    }
}