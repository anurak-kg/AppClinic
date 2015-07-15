<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 1:44
 */

namespace App\branch;

use Illuminate\Database\Eloquent\Model;

class branch extends Model
{

    protected $table = 'branch';

    public function employee()
    {
        return $this->hasOne('Appclinic\Appclinic\app\employee', 'emp_id');
    }


}