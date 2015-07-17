<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotations_detail extends Model
{
    protected $table = 'quotations_detail';

    public function Quotations()
    {
        return $this->belongsTo('\App\Quotations', 'quo_id');
    }
}
