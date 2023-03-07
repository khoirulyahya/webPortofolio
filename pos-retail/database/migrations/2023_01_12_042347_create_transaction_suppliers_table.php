<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code',15);
            $table->unsignedBigInteger('officer_id');
            $table->unsignedBigInteger('supplier_id');
            $table->timestamps();

            $table->foreign('officer_id')->references('id')->on('officers');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_suppliers');
    }
}
