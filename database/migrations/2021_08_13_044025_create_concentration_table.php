<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcentrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concentration', function (Blueprint $table) {
            $table->increments('id');
            $table->double('capacity')->default(0.0);
            $table->string('factory_name');
            $table->string('type')->default('realtime'); // 分為 realtime、month、year
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
        Schema::dropIfExists('concentration');
    }
}
