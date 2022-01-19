<?php

use Illuminate\Database\Seeder;
use App\User;
use App\DeliveryMan;
use Illuminate\Support\Facades\Hash;

class DeliveryMenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // One (ygn)
      $user1 = new User;
      $user1->name = 'Delivery Man One';
      $user1->email = 'deliveryman1@gmail.com';
      $user1->password = Hash::make('12345678');
      $user1->save();

      $user1->assignRole('delivery_man');

      $delivery_man1 = new DeliveryMan;
      $delivery_man1->phone_no = '09-123456789';
      $delivery_man1->address = 'Baho Street, Mayangone Township';
      $delivery_man1->user_id = $user1->id;
      $delivery_man1->city_id = 1;
      $delivery_man1->save();

      $delivery_man1->townships()->attach([25,26]);


      // Two (ygn)
      $user2 = new User;
      $user2->name = 'Delivery Man Two';
      $user2->email = 'deliveryman2@gmail.com';
      $user2->password = Hash::make('12345678');
      $user2->save();

      $user2->assignRole('delivery_man');

      $delivery_man2 = new DeliveryMan;
      $delivery_man2->phone_no = '09-123456789';
      $delivery_man2->address = 'Baho Street, Mayangone Township';
      $delivery_man2->user_id = $user2->id;
      $delivery_man2->city_id = 1;
      $delivery_man2->save();

      $delivery_man2->townships()->attach([2,3,4]);


      // Car (ygn)
      $user4 = new User;
      $user4->name = 'Car One';
      $user4->email = 'carone@gmail.com';
      $user4->password = Hash::make('12345678');
      $user4->save();

      $user4->assignRole('delivery_man');

      $delivery_man4 = new DeliveryMan;
      $delivery_man4->phone_no = '09-123456789';
      $delivery_man4->address = 'Baho Street, Mayangone Township';
      $delivery_man4->user_id = $user4->id;
      $delivery_man4->city_id = 1;
      $delivery_man4->status = 1;

      $delivery_man4->save();


      // Agent (mdy)
      $user3 = new User;
      $user3->name = 'MDY DeliveryMan';
      $user3->email = 'mdy@gmail.com';
      $user3->password = Hash::make('12345678');
      $user3->save();

      $user3->assignRole('delivery_man');

      $delivery_man3 = new DeliveryMan;
      $delivery_man3->phone_no = '09-123456789';
      $delivery_man3->address = 'Aungmyaetharzan township';
      $delivery_man3->user_id = $user3->id;
      $delivery_man3->city_id = 2;
      $delivery_man3->save();

      $delivery_man3->townships()->attach([49]);

    }
}
