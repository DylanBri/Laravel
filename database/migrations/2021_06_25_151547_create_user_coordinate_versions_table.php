<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCoordinateVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coordinate_versions', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->string('quality', 50)->nullable();
            $table->string('address',255)->nullable();
            $table->string('address2',255)->nullable();
            $table->string('zip_code',10)->nullable();
            $table->string('city',255)->nullable();
            $table->string('region',255)->nullable();
            $table->string('country',255)->nullable();
            $table->string('phone',50)->nullable();
            $table->string('mobile',50)->nullable();
            $table->boolean('enabled')->default(true);
            $table->boolean('suppressed')->default(false);
            $table->timestamps();
            $table->unsignedInteger('version')->default(0);
            $table->dateTime('version_created_at')->nullable();
            $table->string('version_created_by',255)->nullable();
            $table->string('version_comment',255)->nullable();
            $table->primary(['id', 'version']);
            $table->foreign('id')->references('id')->on('user_coordinates')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('user_categories')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_coordinate_versions');
    }
}
