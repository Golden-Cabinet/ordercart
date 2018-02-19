<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public static function getRole($roleId)
    {
        $role = new self;
        $getRole = $role::find($roleId);

        return $getRole['name'];
    }
}
