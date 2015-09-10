<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customer';
    protected $primaryKey = 'cus_id';

    public function Quotations()
    {
        return $this->hasmany('\App\Quotations','cus_id');
    }

    public function TreatHistory()
    {
        return $this->hasmany('\App\TreatHistory','emp_id');
    }

    public function Branch(){
        return $this->belongsTo('\App\Branch');
    }

    public function course(){

        return $this->belongsToMany('App\Course','quotations_detail','quo_id','course_id')
            ->withPivot('qty','treat_status','created_at','updated_at');
    }
    public function sales(){
        return $this->hasMany('\App\Sales','cus_id');
    }
    public function product(){
        return $this->belongsToMany('App\Product','sales_detail','sales_id','product_id')
            ->withPivot('sales_de_qty','sales_de_net_price','created_at','updated_at');
    }

}

