<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatHasMedicine extends Model
{
    protected $table = 'treat_has_medicine';
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
    public function treat_has_medicine(){
        return $this->belongsTo('App\TreatHasMedicine','treat_id');
    }
}
