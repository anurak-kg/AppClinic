<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class quotations extends Model
{

    protected $table = 'quotations';
    protected $primarykey = 'quo_id';

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
        return $this->hasmany('\App\Treatment','quo_id');
    }

}