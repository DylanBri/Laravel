<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_queues', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('action', 50)->nullable();
            $table->mediumText('data')->nullable();
            $table->mediumText('log')->nullable();
            $table->tinyInteger('state')->default(0);

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
        Schema::dropIfExists('log_queues');
    }
}
