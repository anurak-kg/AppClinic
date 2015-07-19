<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_group extends Model
{
    protected $table = 'product_group';
    protected $primaryKey = 'pg_id';

    public function Product()
    {
        return $this->hasmany('\App\Product','pg_id');
    }
    public function Product_type()
    {
        return $this->belongsTo('\App\Product_type', 'pt_id');
    }

}
