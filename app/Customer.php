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
    public function customer(){

        return $this->belongsToMany('App\Course','quotations_detail','quo_id','course_id')
            ->withPivot('qty','treat_status','created_at','updated_at');
    }

}

