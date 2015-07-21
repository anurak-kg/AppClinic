<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'course_id';
    public function detail()
    {
        return $this->hasMany('App\Course_detail');
    }
    public function medicine(){
        return $this->hasMany('App\Medicine');
    }


}
