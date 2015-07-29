<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'course_id';
    public $incrementing = false;


    public function medicine(){

        return $this->belongsToMany('App\Product','course_medicine','course_id','product_id')
            ->withPivot('qty','created_at','updated_at');
    }

}
