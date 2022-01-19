<?php

use Illuminate\Database\Seeder;
use App\Bank;
class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Bank::create(['name'=>'Cash','amount'=>100000]);
      Bank::create(['name'=>'KBZ','amount'=>100000]);
      Bank::create(['name'=>'AYA','amount'=>100000]);
      Bank::create(['name'=>'KBZ Pay','amount'=>100000]);
      Bank::create(['name'=>'CB','amount'=>100000]);
    }
}
