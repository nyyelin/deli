<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ways', function (Blueprint $table) {
            $table->id();
            $table->string('status_code');
            $table->date('delivery_date')->nullable();
            $table->date('refund_date')->nullable();

            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('delivery_man_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('status_id');
            $table->string('remark')->nullable();;

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('item_id')
                    ->references('id')->on('items')
                    ->onDelete('cascade');
            $table->foreign('delivery_man_id')
                    ->references('id')->on('delivery_men')
                    ->onDelete('cascade');
            $table->foreign('staff_id')
                    ->references('id')->on('staff')
                    ->onDelete('cascade');
            $table->foreign('status_id')
                    ->references('id')->on('statuses')
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
        Schema::dropIfExists('ways');
    }
}
