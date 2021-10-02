<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\HF;
use App\HFDaily;
use App\HFSpec;
use App\HFYear;
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
}
