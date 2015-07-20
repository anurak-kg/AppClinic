<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customer';
    protected $primaryKey = 'cus_id';

    public function Quotations()
    {
        return $this->hasmany('\App\Quotations','quo_id');
    }

    public function Treatment()
    {
        return $this->hasmany('\App\Treatment','tre_id');
    }

    public function Disease_detail ()
    {
        return $this->hasmany('\App\Disease_detail','dis_de_id');
    }

    public function Allergic_detail ()
    {
        return $this->hasmany('\App\Allergic_detail','gic_de_id');
    }

}

