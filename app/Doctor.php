<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';
    protected $primaryKey = 'dr_id';

    public function Treatment_detail()
    {
        return $this->hasmany('\App\Treatment','tre_id');
    }
}
