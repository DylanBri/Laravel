<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRightAndProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('right_and_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('right_id');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('role_id');
            $table->foreignId('client_id');
            $table->boolean('enabled')->default(true);

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
        Schema::dropIfExists('right_and_profile');
    }
}
