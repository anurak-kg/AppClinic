<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    protected $table = 'order_detail';
    public function Order(){
        return $this->belongsTo('\App\Order','order_id');
    }
    public function Product(){
        return $this->belongsTo('\App\Product','product_id');
    }
}
