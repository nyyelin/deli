<?php

use Illuminate\Database\Seeder;
use App\PaymentType;
class PaymenttypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         PaymentType::create(['name'=>'Cash']);
         PaymentType::create(['name'=>'Bank']);
         PaymentType::create(['name'=>'Cash+Bank']);
         PaymentType::create(['name'=>'Os']);
         PaymentType::create(['name'=>'Only Deli']);
         PaymentType::create(['name'=>'Only Deposit']);
    }
}
