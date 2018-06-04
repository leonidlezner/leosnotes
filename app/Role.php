<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Role extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'title',
    ];

    public function __toString()
    {
        return sprintf('Role "%s"', $this->title);
    }
    
    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }

    public function forceDelete()
    {
        $this->users()->detach();
        return parent::forceDelete();
    }
}
