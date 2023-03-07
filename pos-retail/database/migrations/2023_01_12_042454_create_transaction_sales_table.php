<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code',15);
            $table->unsignedBigInteger('officer_id');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->timestamps();

            $table->foreign('officer_id')->references('id')->on('officers');
            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_sales');
    }
}
