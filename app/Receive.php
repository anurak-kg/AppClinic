<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    protected $table = 'receive';
    protected $primaryKey = 'receive_id';

    public function User()
    {
        return $this->belongsTo('App\User', 'emp_id');
    }
    public function product(){

        return $this->belongsToMany('App\Product','receive_detail','receive_id','product_id')
            ->withPivot('receive_de_qty','receive_de_qty_return','receive_de_text','updated_at','created_at');
    }

    public function Vendor()
    {
        return $this->belongsTo('\App\Vendor', 'ven_id');
    }
    public function Order()
    {
        return $this->belongsTo('\App\Order', 'order_id');
    }
    public function Re_turn() {
        return $this->hasmany('\App\Return');
    }
}
