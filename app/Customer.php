<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customer';
    protected $primaryKey = 'cus_id';

    public function Quotations()
    {
        return $this->hasmany('\App\Quotations');
    }

    public function Treatment()
    {
        return $this->hasmany('\App\Treatment');
    }
    public function Branch(){
        return $this->belongsTo('\App\Branch','branch_id');
    }

}

