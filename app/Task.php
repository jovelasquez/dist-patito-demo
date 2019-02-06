<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Task extends Eloquent
{
    /**
     * Default Connection
     * 
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Collection Name
     * 
     * @var string
     */
    protected $collection = 'tasks';

    /**
     * attributes
     *
     * @var array
     */
    protected $fillable = [
        'fecha',
        'nombre',
        'direccion',
        'logitud',
        'latitud',
        'mercancia',
        'estado',
        'distributor'
    ];

    /**
     * Get the distributor that owns the tasks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}