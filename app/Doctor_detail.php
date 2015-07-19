<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor_detail extends Model
{
    protected $table = 'doctor_detail';
    protected $primaryKey = 'dr_dr_id';

    public function Doctor()
    {
        return $this->belongsTo('\App\Doctor','dr_id');
    }
}
