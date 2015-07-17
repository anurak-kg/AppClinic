<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_type extends Model
{
    protected $table = 'product_type';
    protected $primaryKey = 'pt_id';

    public function Product_group()
    {
        return $this->hasMany('\App\Product_group','pt_id');
    }

}
