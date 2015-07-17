<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment_detail extends Model
{
    protected $table = 'treatment_detail';

    public function Treatment()
    {
        return $this->belongsTo('\App\Treatment', 'tre_id');
    }

}
