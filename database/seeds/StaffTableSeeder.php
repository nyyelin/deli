<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Staff;
use Illuminate\Support\Facades\Hash;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new User;
      $user->name = 'Staff';
      $user->email = 'staff@gmail.com';
      $user->password = Hash::make('12345678');
      $user->save();

      $user->assignRole('staff');

      $staff = new Staff;
      $staff->phone_no = '09-123456789';
      $staff->address = 'Baho Street, Mayangone Township';
      $staff->joined_date = '2019-02-01';
      $staff->designation = 'Store Manager';
      $staff->user_id = $user->id;
      $staff->save();
    }
}
