<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 16/7/2558
 * Time: 21:48
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_detail extends Model
{

    protected $table = 'product_detail';

    public function product()
    {
        return $this->belongsTo('\App\Product', 'product_id');
    }
    public function Treatment()
    {
        return $this->belongsTo('\App\Treatment', 'tre_id');
    }

}