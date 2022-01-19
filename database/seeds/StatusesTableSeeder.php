<?php

use Illuminate\Database\Seeder;
use App\Status;
class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Status::create([
        'codeno' => '001',
        'description' =>'success' ,
      ]);
      Status::create([
        'codeno' => '002',
        'description' =>'return' ,
      ]);
      Status::create([
        'codeno' => '003',
        'description' =>'refund' ,
      ]);
      Status::create([
        'codeno' => '004',
        'description' =>'delay' ,
      ]);
       Status::create([
        'codeno' => '005',
        'description' =>'assign' ,
      ]);
    }
}
