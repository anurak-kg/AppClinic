<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Re_turn extends Model
{
    protected $table = 'return';
    protected $primaryKey = 'return_id';
    public $incrementing = false;

    public function User()
    {
        return $this->belongsTo('App\User', 'emp_id');
    }

    public function product()
    {

        return $this->belongsToMany('App\Product', 'return_detail', 'return_id', 'product_id')
            ->withPivot('return_de_qty', 'return_de_text', 'updated_at', 'created_at');
    }

    public function Vendor()
    {
        return $this->belongsTo('\App\Vendor', 'ven_id');
    }

    public function Order()
    {
        return $this->belongsTo('\App\Order', 'order_id');
    }

    public function receive()
    {
        return $this->belongsTo('\App\Receive', 'receive_id');
    }
    public function branch()
    {
        return $this->belongsTo('\App\Branch', 'branch_id');
    }
}
