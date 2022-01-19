<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(CitiesTableSeeder::class);
      $this->call(TownshipsTableSeeder::class);
      $this->call(BanksTableSeeder::class);
      $this->call(ExpensetypesTableSeeder::class);
      $this->call(PaymenttypesTableSeeder::class);
      $this->call(StatusesTableSeeder::class);
      $this->call(RolesTableSeeder::class);
      $this->call(UsersTableSeeder::class);
      $this->call(StaffTableSeeder::class);
      $this->call(DeliveryMenTableSeeder::class);
      $this->call(ClientsTableSeeder::class);
      $this->call(SenderGateSeeder::class);
      $this->call(SenderPostofficeSeeder::class);
    }
}
