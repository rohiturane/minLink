<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
	/**
	 * Name should be lowercase.
	 *
	 * @param string $value Name value
	 */
	public function setNameAttribute($value)
	{
		$this->attributes['name'] = strtolower($value);
	}

	public function getRoleNameAttribute()
	{
		return ucwords($this->name);
	}
}