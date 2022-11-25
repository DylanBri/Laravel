<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->unsignedInteger('version')->default(0);
            $table->dateTime('version_created_at')->nullable();
            $table->string('version_created_by', 255)->nullable();
            $table->string('version_comment', 255)->nullable();
        });

        Schema::create('client_versions', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->default(0);
            $table->string('name', 255)->nullable();
            $table->string('folder', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('licence', 50)->nullable();
            $table->dateTime('licence_expired_at')->nullable();
            $table->string('socket_host', 255)->nullable();
            $table->string('socket_port', 255)->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
            $table->unsignedInteger('version')->default(0);
            $table->dateTime('version_created_at')->nullable();
            $table->string('version_created_by',255)->nullable();
            $table->string('version_comment',255)->nullable();
            $table->primary(['id', 'version']);
            $table->foreign('id')->references('id')->on('clients')
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
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['version', 'version_created_at', 'version_created_by', 'version_comment']);
        });
        Schema::dropIfExists('client_versions');
    }
}
