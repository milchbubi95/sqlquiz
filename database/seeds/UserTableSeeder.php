<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_student = Role::where('name', 'student')->first();
        $role_dozent  = Role::where('name', 'dozent')->first();
        $student = new User();
        $student->name = 'Test Student';
        $student->email = 'student@example.com';
        $student->password = bcrypt('secret');
        $student->save();
        $student->roles()->attach($role_student);
        $dozent = new User();
        $dozent->name = 'Test Dozent';
        $dozent->email = 'dozent@example.com';
        $dozent->password = bcrypt('secret');
        $dozent->save();
        $dozent->roles()->attach($role_dozent);
    }
}
