<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_bank extends Model
{
    protected $table = 'payment_bank';
    protected $primaryKey = 'bank_id';

    public function payment_detail()
    {
        return $this->hasMany('\App\Payment_detail');
    }
}
