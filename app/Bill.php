<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bill';
    protected $primaryKey = 'bill_id';

    public function bill_detail()
    {
        return $this->hasMany('\App\Bill_detail');
    }
    public function User()
    {
        return $this->belongsTo('\App\User','emp_id');
    }
    public function Quotations_detail()
    {
        return $this->belongsTo('\App\Quotations_detail','quo_de_id');
    }
    public function custumer()
    {
        return $this->belongsTo('\App\Customer','cus_id');
    }
    public function payment()
    {
        return $this->belongsTo('\App\Payment','payment_id');
    }
    public function Branch()
    {
        return $this->belongsTo('\App\Branch','branch_id');
    }
    public function payment_detail()
    {
        return $this->belongsTo('App\Payment_detail','payment_de_id');
    }

}
