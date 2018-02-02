<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressState extends Model
{
    protected $fillable = ['name','abbreviation'];

    public function userAddress()
    {
        return $this->belongsTo('App\Address');
    }

    public function patientAddress()
    {
        return $this->belongsTo('App\PatientAddress');
    }
}
