<?php

namespace App\Customs\Transformers;

class DistributorTransformer extends Transformer
{
    protected $resourceName = 'distributor';

    public function transform($data)
    {

        return [
            '_id' => $data['_id'],
            'login' => $data['login'],
            'email' => $data['email'],
            'createdAt' => $data['created_at']->toAtomString(),
            'updatedAt' => $data['updated_at']->toAtomString()
        ];
    }
}