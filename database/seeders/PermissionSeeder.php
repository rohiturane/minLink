<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//$role = Role::insert(['name'=>'admin', 'guard_name'=>'web'],['name'=>'user', 'guard_name'=>'web']);
        $entities  = ['roles', 'users','page_information','setting','post','transaction','domain','link'];

		$abilities = ['add', 'delete', 'delete_own', 'edit', 'edit_own', 'view', 'view_own'];

		echo "\n";
		echo "\nCreated permissions: \n";

		foreach ($entities as $entity)
		{
			echo "\n";

			foreach ($abilities as $ability)
			{
				$permission_name = $ability . '_' . $entity;
				Permission::firstOrCreate(['name' => $permission_name]);
				echo $permission_name." ";
			}
		}

        $super_admin = Role::findOrFail(1);
        $super_admin->givePermissionTo(Permission::all());
    }
}
