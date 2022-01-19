<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('pickup_date');
            $table->integer('status')->default(0); 
            // 0 (ချိန်းထားတုန်း) ,1 (လာယူပြီးပြီ)
            $table->longText('remark')->nullable();
            $table->text('file')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('amount')->default(0);
            $table->unsignedBigInteger('client_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('client_id')
                    ->references('id')->on('clients')
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
        Schema::dropIfExists('schedules');
    }
}
