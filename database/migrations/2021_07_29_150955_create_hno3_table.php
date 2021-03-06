<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHno3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hno3', function (Blueprint $table) {
            $table->increments('id');
            $table->string('machine_name');
            $table->string('location');
            $table->double('capacity')->default(0.0);
            //$table->string('type')->default('realtime'); // 分為 realtime、month、year
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
        Schema::dropIfExists('hno3');
    }
}
