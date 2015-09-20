<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'sales_id';
    public $incrementing = false;
    public function User(){
        return $this->belongsTo('\App\User','emp_id');
    }

    public function product(){

        return $this->belongsToMany('App\Product','sales_detail','sales_id','product_id')
            ->withPivot('sales_de_qty','sales_de_price','sales_de_discount','sales_de_disamount','created_at','sales_de_net_price');
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
        return $this->hasmany('\App\Sales_detail','sales_id');
    }
    public function payment()
    {
        return $this->hasmany('\App\Payment','sales_id');
    }
}
