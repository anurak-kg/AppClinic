<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{

    protected $table = 'employee';

    public function branch()
    {
        return $this->belongsTo('\App\Branch', 'branch_id');
    }

    public function scopeFreesearch($query, $value)
    {
        return $query->where('emp_id','like','%'.$value.'%')
            ->orWhere('emp_name','like','%'.$value.'%')
            ->orWhereHas('branch', function ($q) use ($value) {
                $q->whereRaw(" CONCAT(branch_id, ' ', branch_name) like ?", array("%".$value."%"));
            });

    }

}