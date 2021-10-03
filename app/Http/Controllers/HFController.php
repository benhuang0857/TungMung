<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\HF;
use App\HFDaily;
use App\HFSpec;
use App\HFYear;
use App\HNO3ParaSetting;
use App\HFC0;
use App\Tank;
use DB;

class HFController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $HF = HF::where('datetime', '<=' , date('Y-m-d', strtotime('+2 days')))
                  ->where('datetime', '>=' , date('Y-m-d', strtotime('+0 days')))->get();
        
        $HFDaily = HFDaily::where('Day', '<', date("Y-m-t", strtotime(date("Y-m-d"))) )
                          ->where('Day', '>=', date("Y-m-01", strtotime(date("Y-m-d"))) )->get();
        
        $HFYear = HFDaily::where('Day', '<', date("Y-m-t", strtotime(date("Y-m-d"))) )
                            ->where('Day', '>=', date("Y").'-01-01' )->get();
        
        $spec   = HFSpec::orderBy('created_at', 'desc')->first();

        $resultData = array();
        $resultTimeLabe = array();

        foreach($HF as $item)
        {
            array_push($resultData, $item->HF);
            array_push($resultTimeLabe, $item->datetime);
        }

        //當月累積
        $resultHFMonth = 0;
        foreach($HFDaily as $day)
        {
            $resultHFMonth += $day->HF;
        }

        //當年累積
        $resultHFYear = 0;
        foreach($HFYear as $day)
        {
            $resultHFYear += $day->HF;
        }

        $data = [
            'HF'     => json_encode($resultData),
            'TLable' => json_encode($resultTimeLabe),
            'HFMonth'=> $resultHFMonth,
            'HFYear' => $resultHFYear,
            'Spec'   => $spec
        ];

        return view('hf')->with('DATA', $data);
    }

    public function showReportDay(Request $req)
    {
        $start = $req->start;
        $end = $req->end;

        if($start == null || $end == null)
        {
            $start = date('Y-m-d h:i:s');
            $end = date('Y-m-d h:i:s');
        }

        $HF = HF::where('datetime', '<=' , $end)
                  ->where('datetime', '>=' , $start)->get();

        $data = [
            'HF' => $HF
        ];
        return view('hfreport')->with('DATA', $data);
    }

    public function showChart(Request $req)
    {
        $spec     = HFSpec::orderBy('created_at', 'desc')->first();
        $resultData = array();
        $resultTimeLabe = array();
        
        $chartType = $req->chart_type;

        if($chartType == 'day')
        {
            $HF = HF::where('datetime', '<=' , date('y-m-d', strtotime('+2 days')))
            ->where('datetime', '>=' , date('y-m-d', strtotime('+0 days')))->get();

            foreach($HF as $item)
            {
                array_push($resultData, $item->HF);
                array_push($resultTimeLabe, $item->date_time);
            }
        }
        elseif($chartType == 'month')
        {
            $HF = HFDaily::where('Day', '<', date("Y-m-t", strtotime(date("Y-m-d"))) )
            ->where('Day', '>=', date("Y-m-01", strtotime(date("Y-m-d"))) )->get();

            foreach($HF as $item)
            {
                array_push($resultData, $item->HF);
                array_push($resultTimeLabe, $item->Day);
            }
        }
        else
        {
            $HF_01 = HFYear::where('Month', '=', '1' )->get()->sum('HF');
            $HF_02 = HFYear::where('Month', '=', '2' )->get()->sum('HF');
            $HF_03 = HFYear::where('Month', '=', '3' )->get()->sum('HF');
            $HF_04 = HFYear::where('Month', '=', '4' )->get()->sum('HF');
            $HF_05 = HFYear::where('Month', '=', '5' )->get()->sum('HF');
            $HF_06 = HFYear::where('Month', '=', '6' )->get()->sum('HF');
            $HF_07 = HFYear::where('Month', '=', '7' )->get()->sum('HF');
            $HF_08 = HFYear::where('Month', '=', '8' )->get()->sum('HF');
            $HF_09 = HFYear::where('Month', '=', '9' )->get()->sum('HF');
            $HF_10 = HFYear::where('Month', '=', '10' )->get()->sum('HF');
            $HF_11 = HFYear::where('Month', '=', '11' )->get()->sum('HF');
            $HF_12 = HFYear::where('Month', '=', '12' )->get()->sum('HF');

            $resultData     = [$HF_01, $HF_02, $HF_03, $HF_04, $HF_05, $HF_06,
                               $HF_07, $HF_08, $HF_09, $HF_10, $HF_11, $HF_12];
            $resultTimeLabe = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        }

        $data = [
            'HF'     => json_encode($resultData),
            'TLable'   => json_encode($resultTimeLabe),
            'Spec'     => $spec
        ];

        return view('hfchart')->with('DATA', $data);
    }

    public function setSpecPage()
    {
        return view('hfspec');
    }

    public function submitSpec(Request $req)
    {
        $HFSpec = new HFSpec;
        $HFSpec->top = $req->input('top');
        $HFSpec->bottom = $req->input('bottom');
        $HFSpec->save();
        
        return redirect()->back();
    }

    // 預測
    // public function settingPage()
    // {
    //     return view('hfsetting');
    // }

    // public function passSettingPara(Request $req)
    // {
    //     $HFSetting = new HFParaSetting;
    //     // $HNO3Setting->HNO3_auto_para = $req->input('HNO3_auto_para');
    //     // $HNO3Setting->H2O_auto_para = $req->input('H2O_auto_para');
    //     // $HNO3Setting->HF_auto_para = $req->input('HF_auto_para');
    //     $HFSetting->line_speed = $req->input('line_speed');
    //     $HFSetting->board_width = $req->input('board_width');
    //     $HFSetting->add_time = $req->input('add_time');
    //     $HFSetting->K2 = $req->input('K2');
    //     $HFSetting->K3 = $req->input('K3');
    //     $HFSetting->W_plus = $req->input('W_plus');
    //     $HFSetting->F_plus = $req->input('F_plus');
    //     $HFSetting->V0 = $req->input('V0');

    //     $HFSetting->save();
    //     return redirect()->back();
    // }

    public function calculate()
    {
        $HNO3Setting = HNO3ParaSetting::orderBy('created_at', 'desc')->first();
        $HNO3C0 = HFC0::orderBy('created_at', 'desc')->first();
        $Tank = Tank::orderBy('create_date', 'desc')->first();

        //dd($HNO3Setting);

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

        $tank11_C1 = (666*($tank11_N + $N_plus) + $tank11C0*$V0)/( $V0 + ($tank11_N + $N_plus) + ($tank11_F + $F_plus) + ($tank11_W + $W_plus) );
        $tank12_C1 = (666*($tank12_N + $N_plus) + $tank12C0*$V0)/( $V0 + ($tank12_N + $N_plus) + ($tank12_F + $F_plus) + ($tank12_W + $W_plus) );
        $tank22_C1 = (666*($tank22_N + $N_plus) + $tank22C0*$V0)/( $V0 + ($tank22_N + $N_plus) + ($tank22_F + $F_plus) + ($tank22_W + $W_plus) );

        $tank11_C1 = round($tank11_C1, 2);
        $tank12_C1 = round($tank12_C1, 2);
        $tank22_C1 = round($tank22_C1, 2);
        
        if($Tank->tank11_hno3 == null)
        {
            HFC0::create([
                'tank11C0' => 0,
                'tank12C0' => $tank12_C1,
                'tank22C0' => $tank22_C1,
            ]);
        }
        if($Tank->tank12_hno3 == null)
        {
            HFC0::create([
                'tank11C0' => $tank11_C1,
                'tank12C0' => 0,
                'tank22C0' => $tank22_C1,
            ]);
        }
        if($Tank->tank22_hno3 == null)
        {
            HFC0::create([
                'tank11C0' => $tank11_C1,
                'tank12C0' => $tank12_C1,
                'tank22C0' => 0,
            ]);
        }
        
    }

    public function predictPage()
    {
        $HNO3C0 = HFC0::all();

        $Tank_Last = Tank::orderBy('create_date', 'desc')->first();

        $tank11_resultData = array();
        $tank12_resultData = array();
        $tank22_resultData = array();
        $resultTimeLabe = array();

        foreach($HNO3C0 as $item)
        {
            array_push($tank11_resultData, $item->tank11C0);
            array_push($tank12_resultData, $item->tank12C0);
            array_push($tank22_resultData, $item->tank22C0);
            array_push($resultTimeLabe, date_format($item->created_at, 'Y-m-d H:i:s'));
        }

        $data = [
            'tank11C0'     => json_encode($tank11_resultData),
            'tank12C0'     => json_encode($tank12_resultData),
            'tank22C0'     => json_encode($tank22_resultData),
            'TLable'       => json_encode($resultTimeLabe),
            'Tank_Last'    => $Tank_Last
        ];
        return view('hfpredict')->with('DATA', $data);
    }

    public function showPredictReportDay(Request $req)
    {
        $start = $req->start;
        $end = $req->end;

        if($start == null || $end == null)
        {
            $start = date('Y-m-d h:i:s');
            $end = date('Y-m-d h:i:s');
        }

        $HNO3 = HFC0::where('created_at', '<=' , $end)
                  ->where('created_at', '>=' , $start)->get();

        $data = [
            'HNO3' => $HNO3
        ];
        return view('hfpredictreport')->with('DATA', $data);
    }

    public function predict8HPage(Request $req)
    {
        $C0 = $req->C0;
        $TankNum = $req->tanknum;

        $Tank = Tank::orderBy('create_date', 'desc')->first();
        $HNO3Setting = HNO3ParaSetting::orderBy('created_at', 'desc')->first();

        //設定第一次的C0
        $tankC0 = $C0;

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

        if($TankNum == "tank11")
        {
            $tank_HNO3_auto_para = round($Tank->tank11_hno3);
            $tank_H2O_auto_para = round($Tank->tank11_h2o);
            $tank_HF_auto_para = round($Tank->tank11_hf);
        }
        if($TankNum == "tank12")
        {
            $tank_HNO3_auto_para = round($Tank->tank12_hno3);
            $tank_H2O_auto_para = round($Tank->tank12_h2o);
            $tank_HF_auto_para = round($Tank->tank12_hf);
        }
        if($TankNum == "tank22")
        {
            $tank_HNO3_auto_para = round($Tank->tank22_hno3);
            $tank_H2O_auto_para = round($Tank->tank22_h2o);
            $tank_HF_auto_para = round($Tank->tank22_hf);
        }
        
        $current_time = date("Y-m-d H:i:s");

        $TLableArr = array();
        $TankResultArr = array();

        for($i=1; $i<=32; $i++)
        {
            array_push($TLableArr, date('Y-m-d H:i:s',strtotime('+15 minutes',strtotime($current_time))));
            $current_time = date('Y-m-d H:i:s',strtotime('+15 minutes',strtotime($current_time)));
            /**
             * 運算開始...
             * 求N = 硝酸自動添加參數×線速(M/m)×板寬(mm)×添加時間(5min)×k1
             * 求W = H2O自動添加參數×線速(M/m)×板寬(mm)×添加時間(5min)×k2
             * 求F = 氫氟酸自動添加參數×線速(M/m)×板寬(mm)×添加時間(5min)×k3
             * C1 = 結果參照說明公式
             */
            
            $tank_N = $tank_HNO3_auto_para*$line_speed*$board_width*$add_time*$K1;
            $tank_W = $tank_H2O_auto_para*$line_speed*$board_width*$add_time*$K2;
            $tank_F = $tank_HF_auto_para*$line_speed*$board_width*$add_time*$K3;

            $tank_C1 = (666*($tank_N + $N_plus) + $tankC0*$V0)/( $V0 + ($tank_N + $N_plus) + ($tank_F + $F_plus) + ($tank_W + $W_plus) );
            //$tank_C1 = round($tank_C1, 2);

            array_push($TankResultArr, $tank_C1);

            $tankC0 = $tank_C1;
        }

        $data = [
            'TLable' => json_encode($TLableArr),
            'TankResult' => json_encode($TankResultArr),
            'HNO3Setting' => $HNO3Setting
        ];

        return view('hfpredict8h')->with('DATA', $data);
    }
}
