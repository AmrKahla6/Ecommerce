<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;

class RoleTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user                   =new User();
        $user->name             ="Amr";
        $user->image            ="default_user.png";
        $user->email            ="abdelhamid@gmail.com";
        $user->password         = bcrypt('1234569');
        $user->status_id        =\App\Status::where('slug','active')->firstOrFail()->id;
        $user->save();

        $role                       =new Role();
        $role->name                 ="admin";
        $role->{'display_name:ar'}  ="ادمن";
        $role->{'display_name:en'}  ="admin";
        $role->description          ="admin role";
        $role->save();

        $permissions=Permission::all();
        $role->permissions()->attach($permissions);

        $user->roles()->attach($role);
    }
}
