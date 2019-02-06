<?php

namespace App;

use JWTAuth;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Distributor extends Authenticatable
{
    use Notifiable;

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
    protected $collection = 'distributors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email', 'password', 'created_at', 'update_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * Set the password using bcrypt hash.
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = (password_get_info($value)['algo'] === 0) ? bcrypt($value) : $value;
    }

    /**
     * Generate a JWT token for the user.
     *
     * @return string
     */
    public function getTokenAttribute()
    {
        return JWTAuth::fromUser($this);
    }

    /**
     * Get all the tasks for the distributor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class)->latest();
    }
}