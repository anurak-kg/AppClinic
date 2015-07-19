<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disease_detail extends Model
{
    protected $table = 'disease_detail';
    protected $primaryKey = 'dis_de_id';

    public function Customer()
    {
        return $this->belongsTo('\App\Customer', 'cus_id');
    }
}
