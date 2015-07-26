<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'sales_id';
    public function User(){
        return $this->belongsTo('\App\User','emp_id');
    }
    public function Branch()
    {
        return $this->belongsTo('\App\Branch', 'branch_id');
    }
    public function Customer()
    {
        return $this->belongsTo('\App\Customer', 'cus_id');
    }
    public function Sales_detail()
    {
        return $this->hasmany('\App\Sales_detail');
    }
}
