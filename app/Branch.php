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

    public function employee()
    {
        return $this->hasMany('App\Employee');
    }

    static  public  function  getCurrentId(){
        return 1;
    }
    static public function getCurrentName(){
       $branch = Branch::select('branch_name')->find(Branch::getCurrentId())->get()->first();
        return $branch->branch_name;
    }
}