<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customer';
    protected $primaryKey = 'cus_id';

    public function Quotations()
    {
        return $this->hasmany('\App\Quotations','cus_id');
    }

    public function Treatment()
    {
        return $this->hasmany('\App\Treatment','cus_id');
    }

    public function Disease_detail ()
    {
        return $this->hasmany('\App\Disease_detail','cus_id');
    }

    public function Allergic_detail ()
    {
        return $this->hasmany('\App\Allergic_detail','cus_id');
    }

}

