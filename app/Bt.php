<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bt extends Model
{
    protected $table = 'bt';
    protected $primaryKey = 'bt_id';
    public $incrementing = false;


    public function TreatHistory(){
        return $this->belongsTo('\App\TreatHistory', 'treat_id');
    }
    public function User(){
        return $this->belongsTo('\App\User', 'emp_id');
    }


}
