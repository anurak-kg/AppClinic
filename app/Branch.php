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


}