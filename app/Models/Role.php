<?php namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {

	/**
	 * @var array
	 */
	protected $fillable = ['name', 'display_name', 'description', 'level'];
	public function User(){
		return $this->hasMany('\App\User');
	}
}