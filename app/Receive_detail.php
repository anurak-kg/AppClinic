<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receive_detail extends Model
{
    protected $table = 'receive_detail';
    public function Receive(){
        return $this->belongsTo('\App\Receive','receive');
    }
    public function Product(){
        return $this->belongsTo('\App\Product','product_id');
    }
}
