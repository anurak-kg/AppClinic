<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_group extends Model
{
    protected $table = 'product_group';
    public function product_type()
    {
        return $this->belongsTo('\App\Product_type', 'pt_id');
    }
}
