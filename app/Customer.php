<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customer';
    protected $primarykey = 'cus_id';

    public function Quotations()
    {
        return $this->hasmany('\App\Quotations','cus_id');
    }
    public function Treatment()
    {
        return $this->hasmany('\App\Treatment','cus_id');
    }

    public function getSex(){
        return $this->getAttribute('sex');
    }
    public function getSexName(){
        return config('sex.sex'.$this->getSex());
    }
    public function getBlood(){
        return $this->getAttribute('blood');
    }
    public function getBloodName(){
        return config('sex.blood'.$this->getBlood());
    }
}

