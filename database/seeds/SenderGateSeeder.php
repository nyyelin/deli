<?php

use Illuminate\Database\Seeder;
use App\SenderGate;

class SenderGateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      SenderGate::create(['name'=>'Aungmingalar Gate']);
      SenderGate::create(['name'=>'Aungsan Gate']);
      SenderGate::create(['name'=>'Hlaingtharyar Gate']);
      SenderGate::create(['name'=>'Bayintnaung Gate']);
    }
}
