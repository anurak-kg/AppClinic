<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'product';
    protected $primarykey = 'product_id';


    public function product_group()
    {
        return $this->hasOne('\App\Product_group', 'pg_id');
    }

}