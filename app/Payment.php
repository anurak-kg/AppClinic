<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primary_key = 'payment_id';

    public function payment_detail()
    {
        return $this->hasMany('\App\Payment_detail');
    }
    public function sales()
    {
        return $this->belongsTo('\App\Sales', 'sales_id');
    }
    public function customer()
    {
        return $this->belongsTo('\App\User', 'cus_id');
    }
    public function quotations()
    {
        return $this->belongsTo('\App\Quotations', 'quo_id');
    }
    public function quotations_detail()
    {

        return $this->belongsToMany('App\Quotations_detail','payment_detail','payment_id','quo_de_tail')
            ->withPivot('quo_de_price');
    }
}
