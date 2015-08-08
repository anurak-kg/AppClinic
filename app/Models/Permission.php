<?php namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission {

	/**
	 * @var array
	 */
	protected $fillable = ['name', 'display_name', 'description'];

	/**
	 * @param $roleName
	 *
	 * @return bool
	 */
	public function hasRole($roleName)
	{
		foreach($this->roles as $role)
		{
			if($role->name == $roleName)
			{
				return true;
			}
		}
		return false;
	}
}