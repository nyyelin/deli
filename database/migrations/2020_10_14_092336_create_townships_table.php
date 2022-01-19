<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTownshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('townships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('delivery_fees');
            // $table->integer('delirate')->nullable();
            // $table->smallInteger('status'); // incity - 1, gate - 2, post office - 3
            // $table->unsignedBigInteger('city_id');

            $table->softDeletes();
            $table->timestamps();
            
            // $table->foreign('city_id')
            //         ->references('id')->on('cities')
            //         ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('townships');
    }
}
