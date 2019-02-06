<?php

namespace App\Customs\Transformers;

class TaskTransformer extends Transformer
{
    protected $resourceName = 'task';

    public function transform($data)
    {
        return [
            '_id' => $data['_id'],
            'fecha' => $data['fecha'],
            'nombre' => $data['nombre'],
            'direccion' => $data['direccion'],
            'mercancia' => $data['mercancia'],
            'estado' => $data['estado'],
            'createdAt' => $data['created_at']->toAtomString(),
            'updatedAt' => $data['updated_at']->toAtomString(),
            'distributor' => [
                'login' => $data['distributor']['login'],
                'email' => $data['distributor']['email'],
            ]
        ];
    }
}