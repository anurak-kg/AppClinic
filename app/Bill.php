<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bill';
    protected $primaryKey = 'bill_id';
    public function bill_detail()
    {
        return $this->hasMany('\App\Bill_detail');
    }
    public function User()
    {
        return $this->belongsTo('\App\User','emp_id');
    }
    public function Branch()
    {
        return $this->belongsTo('\App\Branch','branch_id');
    }
}
