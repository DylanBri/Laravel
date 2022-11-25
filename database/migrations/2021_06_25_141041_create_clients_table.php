<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('folder', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('zip_code',10)->nullable();
            $table->string('city',255)->nullable();
            $table->string('country',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('phone',50)->nullable();
            $table->string('licence',50)->nullable();
            $table->dateTime('licence_expired_at')->nullable();
            $table->string('socket_host', 255)->nullable();
            $table->string('socket_port', 255)->nullable();
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
        Schema::dropIfExists('clients');
    }
}
