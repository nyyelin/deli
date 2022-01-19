<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverymanTownshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_man_township', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('delivery_men_id');
            $table->unsignedBigInteger('township_id');
            
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('delivery_men_id')
                    ->references('id')->on('delivery_men')
                    ->onDelete('cascade');

            $table->foreign('township_id')
                    ->references('id')->on('townships')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_man_townships');
    }
}
