<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';
    protected $primaryKey = 'dr_id';

    public function Treatment_detail()
    {
        return $this->hasmany('\App\Treatment_detail');
    }
    public function Doctor_event()
    {
        return $this->hasmany('\App\Doctor_event');
    }
    public function Train_detail()
    {
        return $this->hasmany('\App\Train_detail');
    }
    public function Education_detail()
    {
        return $this->hasmany('\App\Education_detail');
    }
}
