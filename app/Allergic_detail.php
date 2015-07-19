<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allergic_detail extends Model
{

    protected $table = 'allergic_detail';
    protected $primaryKey = 'gic_de_id';

    public function Customer()
    {
        return $this->belongsTo('\App\Customer', 'cus_id');
    }
}
