<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('codeno');
            $table->date('assign_date');
            $table->date('expired_date')->nullable();
            $table->integer('deposit')->default(0);
            $table->integer('amount')->default(0);
            $table->integer('delivery_fees')->default(0);
            $table->integer('other_fees')->default(0);
            $table->string('receiver_name');
            $table->text('receiver_address')->nullable();
            $table->string('receiver_phone_no')->nullable();
            $table->longText('remark')->nullable();
            $table->string('paystatus')->default(0);
            $table->integer('status')->default(0); // 0 for unpaid, 1 for prepaid
            // 0,1 (ပုံမှန်ဆို မပေးရသေးတာ)
            
            $table->unsignedBigInteger('pickup_id');
            $table->unsignedBigInteger('township_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->string('error_remark')->nullable();
            $table->unsignedBigInteger('sender_gate_id')->nullable();
            $table->unsignedBigInteger('sender_postoffice_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('pickup_id')
                    ->references('id')->on('pickups')
                    ->onDelete('cascade');
                    
            $table->foreign('sender_gate_id')
                    ->references('id')->on('sender_gates')
                    ->onDelete('cascade');

            $table->foreign('sender_postoffice_id')
                    ->references('id')->on('sender_postoffices')
                    ->onDelete('cascade');
            $table->foreign('township_id')
                    ->references('id')->on('townships')
                    ->onDelete('cascade');
             $table->foreign('staff_id')
                    ->references('id')->on('staff')
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
        Schema::dropIfExists('items');
    }
}
