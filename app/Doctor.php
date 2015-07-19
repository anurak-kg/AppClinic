<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';
    protected $primaryKey = 'dr_id';

    public function Treatment_detail()
    {
        return $this->hasmany('\App\Treatment_detail','dr_id');
    }
    public function Doctor_detail()
    {
        return $this->hasmany('\App\Doctor_detail','dr_id');
    }
    public function Train_detail()
    {
        return $this->hasmany('\App\Train_detail','dr_id');
    }
    public function Education_detail()
    {
        return $this->hasmany('\App\Education_detail','dr_id');
    }
}
