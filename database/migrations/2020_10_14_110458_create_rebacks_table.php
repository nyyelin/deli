<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRebacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebacks', function (Blueprint $table) {
            $table->id();
            $table->longText('remark');

            $table->unsignedBigInteger('pickup_id');
            $table->unsignedBigInteger('way_id');

            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('pickup_id')
                    ->references('id')->on('pickups')
                    ->onDelete('cascade');
            $table->foreign('way_id')
                    ->references('id')->on('ways')
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
        Schema::dropIfExists('rebacks');
    }
}
