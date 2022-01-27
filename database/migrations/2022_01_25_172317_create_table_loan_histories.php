<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLoanHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_histories', function (Blueprint $table) {
            $table->id();
            $table->string('loan_id')->index();
            $table->integer('loan_term');
            $table->decimal('amount_paid', 15, 2);
            $table->datetime('paid_date')->nullable();
            $table->datetime('pay_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_histories');
    }
}
