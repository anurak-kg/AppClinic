<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotations_detail extends Model
{
    protected $table = 'quotations_detail';

    public function Quotations()
    {
        return $this->belongsTo('\App\Quotations', 'quo_id');
    }
    public function Course()
    {
        return $this->belongsTo('\App\Course', 'course_id','course_id');
    }
    public function course_detail()
    {
        return $this->hasManyThrough('App\Course_detail', 'App\Course','course_id');
    }
}
