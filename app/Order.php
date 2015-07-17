<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primarykey = 'order_id';

    public function employee()
    {
        return $this->belongsTo('\App\Employee', 'emp_id');
    }

    public function vendor()
    {
        return $this->belongsTo('\App\Vendor', 'ven_id');
    }

    public function product()
    {
        return $this->hasMany('\App\Product', 'product_id');
    }

}
