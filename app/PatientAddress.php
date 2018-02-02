<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientAddress extends Model
{
    protected $fillable = ['patients_id','addressType','street','city','address_states_id','zip'];

    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    public function addressType()
    {
        return $this->hasOne('App\AddressType');
    }

    public function addressState()
    {
        return $this->hasOne('App\AddressState');
    }
}
