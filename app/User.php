<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function __toString()
    {
        return sprintf('User "%s"', $this->name);
    }
    
    public function roles()
    {
        return $this->belongsToMany(\App\Role::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($user)
        {
            if ($user->isForceDeleting())
            {
                $user->roles()->detach();
            }
        });
    }
}
