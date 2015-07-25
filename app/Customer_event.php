<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_event extends Model
{
    protected $table = 'customer_event';
    protected $primaryKey = 'event_id';

    public function Customer(){
        return $this->belongsTo('\App\Customer','customer_id');
    }
}
