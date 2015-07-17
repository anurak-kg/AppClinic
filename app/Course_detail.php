<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 16/7/2558
 * Time: 19:17
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class course_detail extends Model
{

    protected $table = 'course_detail';
    protected $primarykey = 'course_de_id';

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }


}