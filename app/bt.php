<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bt extends Model
{
    protected $table = 'bt';
    protected $primaryKey = 'bt_id';

    public function TreatHistory(){
        return $this->belongsTo('\App\TreatHistory', 'treat_id');
    }
    public function User(){
        return $this->belongsTo('\App\User', 'emp_id');
    }


}
