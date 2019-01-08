<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@mail.com';
        $admin->password = 'secret';
        $admin->is_admin = User::ROLE_ADMIN;
        $admin->save();

        $visitor = new User();
        $visitor->name = 'Nick';
        $visitor->email = 'test@mail.com';
        $visitor->password = 'secret';
        $admin->is_admin = User::ROLE_VISITOR;
        $visitor->save();
    }
}
