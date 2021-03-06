<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotations_detail extends Model
{
    protected $table = 'quotations_detail';
    protected $primaryKey = 'quo_de_id';

    public function Quotations()
    {
        return $this->belongsTo('\App\Quotations', 'quo_id');
    }
    public function Course()
    {
        return $this->belongsTo('\App\Course', 'course_id','course_id');
    }
    public function Product()
    {
        return $this->belongsTo('\App\Product', 'product_id','product_id');
    }
    public function course_detail()
    {
        return $this->hasManyThrough('App\Course_detail', 'App\Course','course_id');
    }
    public function payment_detail()
    {
        return $this->hasMany('\App\Payment_detail');
    }
    public function bill()
    {
        return $this->hasMany('\App\Bill');
    }
    public function commission(){
        return $this->hasMany('\App\Commission');
    }

}
