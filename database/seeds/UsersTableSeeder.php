<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new User;
      $user->name = 'Admin';
      $user->email = 'admin@gmail.com';
      $user->password = Hash::make('123456789');
      $user->save();

      $user->assignRole('admin');
    }
}
