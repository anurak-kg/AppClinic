<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 1:44
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $table = 'branch';
    protected $primaryKey = 'branch_id';

    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function Bill(){
        return $this->hasMany('App\Bill');
    }
    static  public  function  getCurrentId(){
        //dd(\Session::get('branch_id'));
        return \Session::get('branch_id');
    }
    static public function getCurrentName(){
       $branch = Branch::find(Branch::getCurrentId());
        return $branch->branch_name;
    }
}