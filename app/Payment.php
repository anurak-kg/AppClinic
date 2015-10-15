<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'payment_id';
    public $incrementing = false;

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
    public function bill(){
        return $this->hasmany('\App\Bill','payment_id');
    }
    public function quotations_detail()
    {
        return $this->belongsTo('\App\Quotations_detail', 'quo_de_id','quo_de_id');
    }
    public function sales_detail()
    {
        return $this->belongsTo('\App\Sales_detail', 'sales_id','sales_id');
    }
}
