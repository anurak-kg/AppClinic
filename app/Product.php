<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'product';
    protected $primaryKey = 'product_id';


    public function product_group()
    {
        return $this->belongsTo('\App\Product_group', 'pg_id');
    }
    public function medicine(){
        return $this->hasMany('\App\Medicine');
    }
}