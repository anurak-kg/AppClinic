<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{

    protected $table = 'employee';

    public function branch()
    {
        return $this->hasOne('Appclinic\Appclinic\app\branch', 'branch_id');
    }

}