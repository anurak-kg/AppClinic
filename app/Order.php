<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'order_id';

    public function user()
    {
        return $this->belongsTo('\App\User', 'emp_id');
    }

    public function vendor()
    {
        return $this->belongsTo('\App\Vendor', 'ven_id');
    }

    public function product(){

        return $this->belongsToMany('App\Product','order_detail','order_id','product_id')
            ->withPivot('order_de_qty','order_de_price','order_de_discount','created_at');
    }
    public function Receive()
    {
        return $this->hasMany('\App\Receive');
    }

    public function branch()
    {
        return $this->belongsTo('\App\Branch', 'branch_id');
    }
    public function Re_turn() {
        return $this->hasmany('\App\Return');
    }
}
