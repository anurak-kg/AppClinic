<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education_detail extends Model
{
    protected $table = 'education_detail';
    protected $primaryKey = 'edu_de_id';
    public function Doctor(){
        return $this->belongsTo('\App\Doctor','dr_id');
    }
}
