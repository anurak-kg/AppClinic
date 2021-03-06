<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword,EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getRole(){
        $position = Position::find($this->getAttribute('position_id'));
                    return $position->role;

    }
    public function getRoleName(){
        return config('shop.role.'.$this->getRole());
    }
    public function hasPermssion($permission){
        if($this->getRole() < $this->getLevel($permission))
        {
            return false;
        }
        return true;
    }
    private function getLevel($level){
        return config('shop.roleCon.'.$level);
    }
    public function Branch(){
        return $this->belongsTo('\App\Branch', 'branch_id');
    }
    public function Role(){
        return $this->belongsTo('\App\Models\Role', 'position_id');
    }
    public function Doctor_event(){
        return $this->hasMany('\App\Doctor_event');
    }
    public function bt(){
        return $this->hasMany('App\bt');
    }
    public function Bill(){
        return $this->hasMany('App\Bill');
    }
    public function Commission(){
        return $this->hasMany('App\Commission');
    }
}
