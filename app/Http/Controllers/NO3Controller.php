<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NO3Setting;

class NO3Controller extends Controller
{
    public function settingPage()
    {
        return view('no3setting');
    }

    public function passSettingPara(Request $req)
    {
        $NO3Setting = new NO3Setting;
        $NO3Setting->C0 = $req->input('C0');
        $NO3Setting->NO3_auto_para = $req->input('NO3_auto_para');
        $NO3Setting->H2O_auto_para = $req->input('H2O_auto_para');
        $NO3Setting->HF_auto_para = $req->input('HF_auto_para');
        $NO3Setting->line_speed = $req->input('line_speed');
        $NO3Setting->board_width = $req->input('board_width');
        $NO3Setting->add_time = $req->input('add_time');
        $NO3Setting->K1 = $req->input('K1');
        $NO3Setting->K2 = $req->input('K2');
        $NO3Setting->K3 = $req->input('K3');
        $NO3Setting->N_plus = $req->input('N_plus');
        $NO3Setting->W_plus = $req->input('W_plus');
        $NO3Setting->F_plus = $req->input('F_plus');
        $NO3Setting->V0 = $req->input('V0');

        $NO3Setting->save();
        return redirect()->back();
    }

    public function calculate()
    {
        $NO3Setting = NO3Setting::first();

        $C0 = $NO3Setting->C0;
        $NO3_auto_para = $NO3Setting->NO3_auto_para;
        $H2O_auto_para = $NO3Setting->H2O_auto_para;
        $HF_auto_para = $NO3Setting->HF_auto_para;
        $line_speed = $NO3Setting->line_speed;
        $board_width = $NO3Setting->board_width;
        $add_time = $NO3Setting->add_time;
        $K1 = $NO3Setting->K1;
        $K2 = $NO3Setting->K2;
        $K3 = $NO3Setting->K3;
        $N_plus = $NO3Setting->N_plus;
        $W_plus = $NO3Setting->W_plus;
        $F_plus = $NO3Setting->F_plus;
        $V0 = $NO3Setting->V0;

        /**
         * 運算開始...
         * 求N = 硝酸自動添加參數×線速(M/m)×板寬(mm)×添加時間(5min)×k1
         * 求W = H2O自動添加參數×線速(M/m)×板寬(mm)×添加時間(5min)×k2
         * 求F = 氫氟酸自動添加參數×線速(M/m)×板寬(mm)×添加時間(5min)×k3
         * C1 = 結果參照說明公式
         */
        
        $N = $NO3_auto_para*$line_speed*$board_width*$add_time*$K1;
        $W = $H2O_auto_para*$line_speed*$board_width*$add_time*$K2;
        $F = $HF_auto_para*$line_speed*$board_width*$add_time*$K3;

        $C1 = (830*($N + $N_plus) + $C0*$V0)/( $V0 + ($N + $N_plus) + ($F + $F_plus) + ($W + $W_plus) );

        dd($C1);
    }
}
