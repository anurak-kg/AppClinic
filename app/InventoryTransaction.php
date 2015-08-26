<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $table = 'inventory_transaction';
    protected $primaryKey = 'inv_id';
    public $incrementing = false;

}
