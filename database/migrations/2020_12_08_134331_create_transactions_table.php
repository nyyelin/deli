<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('income_id')->nullable();
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->unsignedBigInteger('tobank_id')->nullable();
            $table->integer('amount');
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('bank_id')
                    ->references('id')->on('banks')
                    ->onDelete('cascade');

            $table->foreign('income_id')
                    ->references('id')->on('incomes')
                    ->onDelete('cascade');

            $table->foreign('expense_id')
                    ->references('id')->on('expenses')
                    ->onDelete('cascade');

            $table->foreign('tobank_id')
                    ->references('id')->on('banks')
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
        Schema::dropIfExists('transactions');
    }
}
