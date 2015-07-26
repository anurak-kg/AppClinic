<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_detail extends Model
{
    protected $table = 'sales_detail';
    public function Sales(){
        return $this->belongsTo('\App\Sales','sales_id');
    }
    public function Product(){
        return $this->belongsTo('\App\Product','product_id');
    }
}
