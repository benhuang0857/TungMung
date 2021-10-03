<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHfParasetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hf_paraset', function (Blueprint $table) {
            $table->increments('id');
            //$table->float('C0')->comment('估算前濃度');
            // $table->float('HNO3_auto_para')->comment('硝酸自動添加參數');
            // $table->float('H2O_auto_para')->comment('H2O自動添加參數');
            // $table->float('HF_auto_para')->comment('氫氟酸自動添加參數');
            $table->float('line_speed')->comment('線速(M/m)');
            $table->float('board_width')->comment('板寬(mm)');
            $table->float('add_time')->comment('添加時間(5min)');
            //$table->float('K1')->comment('k1');
            $table->float('K2')->comment('k2');
            $table->float('K3')->comment('k3');
            //$table->float('N_plus')->comment('硝酸一次性添加體積(L)');
            $table->float('W_plus')->comment('H2O一次性添加體積(L)');
            $table->float('F_plus')->comment('氫氟酸一次性添加體積(L)');
            $table->float('V0')->comment('估算前混酸總體積(L)');
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
        Schema::dropIfExists('hf_paraset');
    }
}
