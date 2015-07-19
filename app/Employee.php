<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'emp_id';

    public function Quotations()
    {
        return $this->hasmany('\App\Quotations','emp_id');
    }
    public function Treatment()
    {
        return $this->hasmany('\App\Treatment','emp_id');
    }
    public function Branch()
    {
        return $this->belongsTo('\App\Branch', 'branch_id');
    }


}