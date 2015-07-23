<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'course_medicine';

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
