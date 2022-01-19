<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Client;
use Illuminate\Support\Facades\Hash;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $mytime = Carbon\Carbon::now();
      $array = explode('-', $mytime->toDateString());

      // One
      $user1 = new User;
      $user1->name = 'Client One';
      $user1->email = 'client1@gmail.com';
      $user1->password = Hash::make('12345678');
      $user1->save();

      $user1->assignRole('client');

      $client1 = new Client;
      $client1->contact_person = "Ma One";
      $client1->phone_no = '09-123456789';
      $client1->address = 'Home Street, Hlaing Township';
      $client1->account="1234567892345678";
      $client1->owner="client One";
      $client1->codeno = $array[0].$array[1]."001";
      $client1->user_id = $user1->id;
      $client1->township_id = 6;
      $client1->save();

      // Two
      $user2 = new User;
      $user2->name = 'Client Two';
      $user2->email = 'client2@gmail.com';
      $user2->password = Hash::make('12345678');
      $user2->save();

      $user2->assignRole('client');

      $client2 = new Client;
      $client2->contact_person = "Ma Two";
      $client2->phone_no = '09-123456789';
      $client2->address = 'Mati Street, Botahtaung Township';
      $client2->account="1234567892345678";
      $client2->owner="client two";
      $client2->codeno = $array[0].$array[1]."002";
      $client2->user_id = $user2->id;
      $client2->township_id = 22;
      $client2->save();
    }
}
