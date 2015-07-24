<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor_event extends Model
{
    protected $table = 'doctor_event';
    protected $primaryKey = 'event_id';

    public function User(){
        return $this->belongsTo('/App/User','dr_id');
    }
}
