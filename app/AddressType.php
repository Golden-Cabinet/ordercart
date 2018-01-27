<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressType extends Model
{
    protected $fillable = ['name'];

    public function userAddress()
    {
        return $this->belongsTo('App\Address');
    }

    public function patientAddress()
    {
        return $this->belongsTo('App\PatientAddress');
    }
}
