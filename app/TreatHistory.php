<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatHistory extends Model
{
    protected $table = 'treat_history';
    protected $primaryKey = 'treat_id';

    public function product(){
        return $this->belongsToMany('App\Product','treat_has_medicine','treat_id','product_id')
            ->withPivot('qty','created_at','updated_at');

    }

}
