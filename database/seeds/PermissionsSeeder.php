<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	Permission::create(['name' => 'create_user']);
    	Permission::create(['name' => 'delete_user']);
    	Permission::create(['name' => 'edit_user']);
    	Permission::create(['name' => 'index_user']);

        Permission::create(['name' => 'create_roles']);
        Permission::create(['name' => 'delete_roles']);
        Permission::create(['name' => 'edit_roles']);
        Permission::create(['name' => 'index_roles']);
        Permission::create(['name' => 'show_roles']);

        Permission::create(['name' => 'create_permissions']);
        Permission::create(['name' => 'delete_permissions']);
        Permission::create(['name' => 'edit_permissions']);
        Permission::create(['name' => 'index_permissions']);
        Permission::create(['name' => 'show_permissions']);

        

        $role = Role::create(['name' => 'Administrador']);
        $role->syncPermissions(Permission::all());
    }
}
