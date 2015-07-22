<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor_event extends Model
{
    protected $table = 'doctor_event';
    protected $primaryKey = 'event_id';
    public function Doctor(){
        return $this->belongsTo('/App/Doctor','dr_id');
    }
}
