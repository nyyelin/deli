<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->integer('guest_amount')->default(0);

            $table->longText('description');
            $table->unsignedBigInteger('pickup_id')->nullable();;

            $table->unsignedBigInteger('expense_type_id');

            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('city_id');

            // expense_type (other) 
            $table->unsignedBigInteger('item_id')->nullable();

            $table->smallInteger('status'); // 0 (unpaid) / 1 (paid)

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pickup_id')
                    ->references('id')->on('pickups')
                    ->onDelete('cascade');

            $table->foreign('expense_type_id')
                    ->references('id')->on('expense_types')
                    ->onDelete('cascade');

            $table->foreign('client_id')
                    ->references('id')->on('clients')
                    ->onDelete('cascade');

            $table->foreign('staff_id')
                    ->references('id')->on('staff')
                    ->onDelete('cascade');

            $table->foreign('city_id')
                    ->references('id')->on('cities')
                    ->onDelete('cascade');

            $table->foreign('item_id')
                    ->references('id')->on('items')
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
        Schema::dropIfExists('expenses');
    }
}
