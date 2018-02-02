<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['users_id','name','email','area_code','phone','status','deleted'];

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function address()
    {
        return $this->hasOne('App\PatientAddress');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
