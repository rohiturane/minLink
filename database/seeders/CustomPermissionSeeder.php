<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CustomPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  

		$abilities = ['send_email'];

		echo "\n";
		echo "\nCreated permissions: \n";

        foreach ($abilities as $ability)
        {
            Permission::firstOrCreate(['name' => $ability]);
            echo $ability." ";
        }
		

        $super_admin = Role::findOrFail(1);
        $super_admin->givePermissionTo(Permission::all());
    }
}
