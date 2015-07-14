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

    public function scopeFreesearch($query, $value)
    {
        return $query->where('branch_name','like','%'.$value.'%')
            ->orWhere('branch_code','like','%'.$value.'%')
            ->orWhereHas('employee', function ($q) use ($value) {
                $q->whereRaw(" CONCAT(emp_name, ' ', emp_lastname) like ?", array("%".$value."%"));
            });

    }

}