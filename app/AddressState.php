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

    public static function getStateName($stateId)
    {
        $state = new self;
        $getState = $state::find($stateId);

        return $getState['name'];
    }

    public function patientAddress()
    {
        return $this->belongsTo('App\PatientAddress');
    }
}
