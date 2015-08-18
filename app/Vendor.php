<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 2:28
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{

    protected $table = 'vendor';
    protected $primaryKey = 'ven_id';
    public function Order() {
        return $this->hasmany('\App\Order');
    }
    public function Receive() {
        return $this->hasmany('\App\Receive');
    }
    public function Re_turn() {
        return $this->hasmany('\App\Re_turn');
    }
}