<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('cpf', 14)->unique()->nullable();
            $table->date('birth')->nullable();
            $table->char('gender', 1)->nullable();
            $table->string('phone', 14)->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('course_id')->nullable();
            $table->integer('degree')->nullable();
            $table->string('ra', 7)->nullable();
            $table->integer('access_level')->default(0);
            $table->boolean('status')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
