<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@territorial.cdmx.gob.mx',
            'password' => bcrypt('admin'),
            'active' => 1,
            'confirmed' => 1,
        ]);
        $user = User::where('email','admin@territorial.cdmx.gob.mx')->get()->first();
        $role = Role::findOrFail(1);
        $role->syncPermissions(Permission::all());
        $user->assignRole('Administrador');
    }
}
