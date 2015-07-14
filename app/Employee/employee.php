<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 13/7/2558
 * Time: 21:49
 */

namespace App\employee;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{

    protected $table = 'employee';

    public function branch()
    {
        return $this->hasOne('Appclinic\Appclinic\app\branch', 'branch_id');
    }

}