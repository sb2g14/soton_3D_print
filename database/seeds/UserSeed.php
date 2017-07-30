<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'ai1v14@soton.ac.uk',
            'password' => bcrypt('Password1')
        ]);
        $user->assignRole('administrator');

    }
}
