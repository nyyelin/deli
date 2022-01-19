<?php

use Illuminate\Database\Seeder;
use App\ExpenseType;
class ExpensetypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         ExpenseType::create(['name'=>'Client']);
         ExpenseType::create(['name'=>'Office']);
         ExpenseType::create(['name'=>'Salary']);
         ExpenseType::create(['name'=>'Others']);
         ExpenseType::create(['name'=>'Carry Fees']);
    }
}
