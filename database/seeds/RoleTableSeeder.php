<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_student = new Role();
        $role_student->name = 'student';
        $role_student->description = 'Ein Student';
        $role_student->save();
        $role_dozent = new Role();
        $role_dozent->name = 'dozent';
        $role_dozent->description = 'Ein Dozent';
        $role_dozent->save();
    }
}
