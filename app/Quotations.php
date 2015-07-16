<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotations extends Model
{

    protected $table = 'quotations';

    public function Employess()
    {
        return $this->hasOne('\App\Employess', 'emp_id');
    }

    public function Customer()
    {
        return $this->hasOne('\App\Customer', 'cus_id');
    }

    public function Treatment()
    {
        return $this->hasMany('\App\Treatment', 'tre_id');
    }

}