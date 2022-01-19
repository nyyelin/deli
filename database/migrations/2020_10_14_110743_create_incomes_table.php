<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_fees')->nullable();
            $table->integer('deposit')->nullable();
            $table->integer('amount')->nullable();

            $table->integer('bank_amount')->default(0); // default 0
            $table->integer('cash_amount')->default(0); // default 0

            $table->unsignedBigInteger('way_id');
            $table->unsignedBigInteger('payment_type_id');
            
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('way_id')
                    ->references('id')->on('ways')
                    ->onDelete('cascade');
            $table->foreign('payment_type_id')
                    ->references('id')->on('payment_types')
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
        Schema::dropIfExists('incomes');
    }
}
