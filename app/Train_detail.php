<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Train_detail extends Model
{
    protected $table = 'train_detail';
    protected $primaryKey = 'tra_de_id';

    public function Doctor(){
        return $this->belongsTo('\App\Doctor','dr_id');
    }
}
