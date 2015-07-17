<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table = 'treatment';
    protected $primarykey = 'tre_id';

    public function Employee()
    {
        return $this->belongsTo('\App\Employee', 'emp_id');
    }
    public function Customer()
    {
        return $this->belongsTo('\App\Customer', 'cus_id');
    }
    public function Quotations()
    {
        return $this->belongsTo('\App\Quotations', 'quo_id');
    }
    public function Treatment_detail()
    {
        return $this->hasmany('\App\Treatment_detail','tre_id');
    }
    public function Product_detail()
    {
        return $this->hasmany('\App\Product_detail','tre_id');
    }
}
