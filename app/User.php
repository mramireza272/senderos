<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'paterno', 'materno', 'created_by', 'imei', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        /*'password',*/ 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function applications(){
        return $this->hasMany('App\UserApplication');
    }

    public function apps()
    {
        return $this->belongsToMany('App\Application', 'user_applications')
                    ->withPivot('user_id', 'application_id')
                    ->withTimestamps();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function tmplocation()
    {
        $now = Carbon::now()->format('Y-m-d');
        return $this->hasMany('App\LocationTmp', 'imei', 'imei')->whereDate('created_at','=', $now)->orderBy('created_at', 'desc');
    }

    public function tmplocationlast()
    {
        return $this->hasMany('App\LocationTmp', 'imei', 'imei')->orderBy('created_at', 'desc')->take(1);
    }


    public function supervisor_schools()
    {
        return $this->belongsToMany('App\School', 'school_supervisors', 'user_id', 'dif_key');
    }
}
