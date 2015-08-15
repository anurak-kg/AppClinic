<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class return_detail extends Model
{
    protected $table = 'return_detail';
    public function Re_turn(){
        return $this->belongsTo('\App\Return','return_id');
    }
    public function Product(){
        return $this->belongsTo('\App\Product','product_id');
    }
}
