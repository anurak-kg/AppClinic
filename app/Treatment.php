<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table = 'treatment';
    protected $primaryKey = 'tre_id';

    public function User()
    {
        return $this->belongsTo('\App\User', 'id');
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
        return $this->hasmany('\App\Treatment_detail');
    }

    public function Product_detail()
    {
        return $this->hasmany('\App\Product_detail');
    }

    public function Course()
    {
        return $this->belongsTo('\App\Course','course_id');
    }
}
