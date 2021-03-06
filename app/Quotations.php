<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotations extends Model
{

    protected $table = 'quotations';
    protected $primaryKey = 'quo_id';
    public $incrementing = false;



    public function User()
    {
        return $this->belongsTo('\App\User', 'emp_id');
    }

    public function Branch()
    {
        return $this->belongsTo('\App\Branch', 'branch_id');
    }

    public function Customer()
    {
        return $this->belongsTo('\App\Customer', 'cus_id');
    }

    public function course(){

        return $this->belongsToMany('App\Course','quotations_detail','quo_id','course_id')
            ->withPivot('qty','quo_de_id','treat_status','created_at','updated_at');
    }
    public function Quotations_detail()
    {
        return $this->hasmany('\App\Quotations_detail','quo_id');
    }

    public function TreatHistory()
    {
        return $this->hasmany('\App\TreatHistory','emp_id');
    }

}