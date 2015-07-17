<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    protected $primarykey = 'emp_id';

    public function branch()
    {
        return $this->belongsTo('\App\Branch', 'branch_id');
    }


}