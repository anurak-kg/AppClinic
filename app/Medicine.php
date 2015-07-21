<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicine';
    protected $primaryKey = 'med_id';

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Product', 'Product_id');
    }
}
