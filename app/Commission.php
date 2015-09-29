<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $table = 'commission';
    protected $primaryKey = 'com_id';

    public function User(){
        return $this->belongsTo('\App\User', 'emp_id');
    }
    public function Quotations_detail(){
        return $this->belongsTo('\App\Quotations_detail', 'quo_de_id');
    }
}
