<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'users_id',
        'patients_id',
        'formulas_id',
        'sub_total',
        'shipping_cost',
        'discount',
        'total_cost',
        'numberOfScoops',
        'timesPerDay',
        'refills',
        'shipOrPick',
        'pickUpOption',
        'shipOption',
        'billing',
        'notes',
        'instructions',
        'status',
        'deleted'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function patient()
    {
        return $this->hasOne('App\Patient');
    }

    public function formula()
    {
        return $this->hasMany('App\Formula');
    }
    
    public function status()
    {
        return $this->hasOne('App\Status');
    }
}
