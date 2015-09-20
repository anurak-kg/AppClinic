<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill_detail extends Model
{
    protected $table = 'bill_detail';
    protected $primaryKey = 'bill_de_id';
    public function payment_detail()
    {
        return $this->belongsTo('\App\Payment_detail','payment_de_id');
    }
    public function bill()
    {
        return $this->belongsTo('\App\Bill','bill_id');
    }

}
