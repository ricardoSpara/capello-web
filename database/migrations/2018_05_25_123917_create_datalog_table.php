<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatalogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datalog', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('user_ip', 30)->nullable();
            $table->string('user_os', 60)->nullable();
            $table->string('user_browser', 60)->nullable();
            $table->string('module', 60);
            $table->string('action', 60);
            $table->string('description', 150)->nullable();
            $table->integer('item_id')->nullable();
            $table->string('item_table')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datalog');
    }
}
