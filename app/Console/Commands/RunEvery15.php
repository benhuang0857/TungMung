<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\HNO3;
use App\HNO3Daily;
use App\HNO3Spec;
use App\HNO3Year;
use App\HNO3ParaSetting;
use App\HNO3C0;
use App\Tank;
use DB;

class RunEvery15 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Update Tank Data Every 15m';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $HNO3Setting = HNO3ParaSetting::orderBy('created_at', 'desc')->first();
        $HNO3C0 = HNO3C0::orderBy('created_at', 'desc')->first();
        $Tank = Tank::orderBy('create_date', 'desc')->first();

        //設定第一次的C0
        $tank11C0 = 0;
        $tank12C0 = 0;
        $tank22C0 = 0;
        
        //若不是第一次則取出上一次的C0
        if($HNO3C0 != NULL)
        {
            $tank11C0 = $HNO3C0->tank11C0;
            $tank12C0 = $HNO3C0->tank12C0;
            $tank22C0 = $HNO3C0->tank22C0;
        }

        //dd($tank11_HNO3_auto_para);

        //勳哥的自動辨識
        $tank11_HNO3_auto_para = round($Tank->tank11_hno3);
        $tank11_H2O_auto_para = round($Tank->tank11_h2o);
        $tank11_HF_auto_para = round($Tank->tank11_hf);

        $tank12_HNO3_auto_para = round($Tank->tank12_hno3);
        $tank12_H2O_auto_para = round($Tank->tank12_h2o);
        $tank12_HF_auto_para = round($Tank->tank12_hf);

        $tank22_HNO3_auto_para = round($Tank->tank22_hno3);
        $tank22_H2O_auto_para = round($Tank->tank22_h2o);
        $tank22_HF_auto_para = round($Tank->tank22_hf);

        //不會自動變化
        $line_speed = $HNO3Setting->line_speed;
        $board_width = $HNO3Setting->board_width;
        $add_time = $HNO3Setting->add_time;
        $K1 = $HNO3Setting->K1;
        $K2 = $HNO3Setting->K2;
        $K3 = $HNO3Setting->K3;
        $N_plus = $HNO3Setting->N_plus;
        $W_plus = $HNO3Setting->W_plus;
        $F_plus = $HNO3Setting->F_plus;
        $V0 = $HNO3Setting->V0;

        /**
         * 運算開始...
         * 求N = 硝酸自動添加參數×線速(M/m)×板寬(mm)×添加時間(5min)×k1
         * 求W = H2O自動添加參數×線速(M/m)×板寬(mm)×添加時間(5min)×k2
         * 求F = 氫氟酸自動添加參數×線速(M/m)×板寬(mm)×添加時間(5min)×k3
         * C1 = 結果參照說明公式
         */
        
        $tank11_N = $tank11_HNO3_auto_para*$line_speed*$board_width*$add_time*$K1;
        $tank11_W = $tank11_H2O_auto_para*$line_speed*$board_width*$add_time*$K2;
        $tank11_F = $tank11_HF_auto_para*$line_speed*$board_width*$add_time*$K3;

        $tank12_N = $tank12_HNO3_auto_para*$line_speed*$board_width*$add_time*$K1;
        $tank12_W = $tank12_H2O_auto_para*$line_speed*$board_width*$add_time*$K2;
        $tank12_F = $tank12_HF_auto_para*$line_speed*$board_width*$add_time*$K3;

        $tank22_N = $tank22_HNO3_auto_para*$line_speed*$board_width*$add_time*$K1;
        $tank22_W = $tank22_H2O_auto_para*$line_speed*$board_width*$add_time*$K2;
        $tank22_F = $tank22_HF_auto_para*$line_speed*$board_width*$add_time*$K3;

        $tank11_C1 = (830*($tank11_N + $N_plus) + $tank11C0*$V0)/( $V0 + ($tank11_N + $N_plus) + ($tank11_F + $F_plus) + ($tank11_W + $W_plus) );
        $tank12_C1 = (830*($tank12_N + $N_plus) + $tank12C0*$V0)/( $V0 + ($tank12_N + $N_plus) + ($tank12_F + $F_plus) + ($tank12_W + $W_plus) );
        $tank22_C1 = (830*($tank22_N + $N_plus) + $tank22C0*$V0)/( $V0 + ($tank22_N + $N_plus) + ($tank22_F + $F_plus) + ($tank22_W + $W_plus) );

        $tank11_C1 = round($tank11_C1, 2);
        $tank12_C1 = round($tank12_C1, 2);
        $tank22_C1 = round($tank22_C1, 2);
        
        if($Tank->tank11_hno3 == null)
        {
            HNO3C0::create([
                'tank11C0' => 0,
                'tank12C0' => $tank12_C1,
                'tank22C0' => $tank22_C1,
            ]);
        }
        if($Tank->tank12_hno3 == null)
        {
            HNO3C0::create([
                'tank11C0' => $tank11_C1,
                'tank12C0' => 0,
                'tank22C0' => $tank22_C1,
            ]);
        }
        if($Tank->tank22_hno3 == null)
        {
            HNO3C0::create([
                'tank11C0' => $tank11_C1,
                'tank12C0' => $tank12_C1,
                'tank22C0' => 0,
            ]);
        }
    }
}
