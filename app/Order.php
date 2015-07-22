<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primarykey = 'order_id';

    public function user()
    {
        return $this->belongsTo('\App\User', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo('\App\Vendor', 'ven_id');
    }

    public function product()
    {
        return $this->hasMany('\App\Product');
    }
    public function Receive()
    {
        return $this->hasMany('\App\Receive');
    }


}
