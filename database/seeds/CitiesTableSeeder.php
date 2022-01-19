<?php

use Illuminate\Database\Seeder;
use App\City;
class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      City::create(['name'=>'Yangon']);
      City::create(['name'=>'Mandalay']);
      City::create(['name'=>'Pyay']);
      City::create(['name'=>'Nay Pyi Taw']);
      City::create(['name'=>'Taunggyi']);
    }
}
