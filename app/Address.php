<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['name'];

    public function addressTypes()
    {
        return $this->hasOne('App\AddressType');
    }

    public function addressState()
    {
        return $this->hasOne('App\AddressState');
    }
}
