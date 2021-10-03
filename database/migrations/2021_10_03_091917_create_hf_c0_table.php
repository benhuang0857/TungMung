<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHfC0Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hf_c0', function (Blueprint $table) {
            $table->increments('id');
            $table->float('tank11C0')->comment('tank1.1估算前濃度');
            $table->float('tank12C0')->comment('tank1.2估算前濃度');
            $table->float('tank22C0')->comment('tank2.2估算前濃度');
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
        Schema::dropIfExists('hf_c0');
    }
}
