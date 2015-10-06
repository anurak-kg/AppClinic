<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_detail extends Model
{
    protected $table = 'payment_detail';

    public function user()
    {
        return $this->belongsTo('\App\User', 'emp_id');
    }
    public function bank()
    {
        return $this->belongsTo('\App\Payment_bank', 'bank_id');
    }
    public function branch()
    {
        return $this->belongsTo('\App\Branch', 'branch_id');
    }
    public function payment()
    {
        return $this->belongsTo('\App\Payment', 'payment_id');
    }

    public function quotations_detail()
    {
        return $this->belongsTo('\App\Quotations_detail', 'quo_de_id');
    }
    public function bill_detail()
    {
        return $this->belongsTo('\App\Bill_detail','payment_de_id','payment_de_id');
    }
    public function bill()
    {
        return $this->hasMany('\App\Bill');
    }
}
