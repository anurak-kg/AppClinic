<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{

    protected $table = 'product';

    public function product_group()
    {
        return $this->hasOne('\App\Product_group', 'pg_id');
    }

}