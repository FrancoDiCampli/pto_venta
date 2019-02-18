<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
    		'name' => 'admin',
    		'email'=> 'admin@mail.com',
    		'password' =>bcrypt('asd123'),
    	]);
    }
}
