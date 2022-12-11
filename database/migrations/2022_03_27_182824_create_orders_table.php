<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->string('project')->nullable();
            $table->string('material')->nullable();
            $table->double('count')->default(0);
            $table->double('done_count')->default(0);
            $table->double('shipped_count')->default(0);
            $table->boolean('archived')->default(false);
            $table->string('status')->default('start');
            $table->string('finishing')->nullable();
            $table->string('notes' , 500)->nullable();
            $table->string('problems' , 500)->nullable();
            $table->date('finish_date')->nullable();
            $table->date('order_date')->default(now());
            $table->date('start_date')->nullable();
            $table->integer('user_id')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
