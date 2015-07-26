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

    public function Vendor()
    {
        return $this->belongsTo('\App\Vendor', 'ven_id');
    }
    public function Order()
    {
        return $this->belongsTo('\App\Order', 'order_id');
    }

}
