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
            $table->string('employeeid')->unique()->command('工號');
            $table->string('email')->unique();
            $table->string('name')->command('姓名');
            $table->string('dept')->default('no')->command('部門');
            $table->string('password');
            $table->string('status')->default('ok')->command('狀態');
            $table->string('role')->default('normal')->command('角色');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
