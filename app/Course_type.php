<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course_type extends Model
{
    protected $table = 'course_type';
    protected $primaryKey = 'ct_id';
    public function Course(){
        return $this->hasMany('App\Course');
    }
}
