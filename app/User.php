<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'user_roles_id',
        'username',
        'area_code',
        'phonePre',
        'phonePost',
        'ext',
        'license_state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->hasOne('App\UserRole');
    }

    public function patients()
    {
        return $this->hasMany('App\Patient');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    // user role specific

    public function adminUsers()
    {
        if(\Auth::user()->user_roles_id != 2)
        {
            return redirect()->route('dashboardindex');
        } else {
            return self::where('user_roles_id','!=','5')->get();
        }
    }

    public function practitionerDestroyPatientAccounts($id)
    {
        $user = self::find($id);
        $user->destroy();
        return redirect()->route('patientsindex')->with('status', 'Patient Was Deleted!');;
    }

    public static function getUserName($id)
    {
        $user = self::find($id); 
        return $user->name;
    }

}
