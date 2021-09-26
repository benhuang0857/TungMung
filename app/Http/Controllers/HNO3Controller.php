<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\HNO3;
use App\HNO3Daily;
use App\HNO3Spec;
use App\HNO3Year;
use DB;

class HNO3Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $HNO3 = HNO3::where('date_time', '<=' , date('y-m-d', strtotime('+2 days')))
        ->where('date_time', '>=' , date('y-m-d', strtotime('+0 days')))->get();

        $HNO3Daily = HNO3Daily::where('Day', '<', date("Y-m-t", strtotime(date("Y-m-d"))) )
                          ->where('Day', '>=', date("Y-m-01", strtotime(date("Y-m-d"))) )->get();

        
        $HNO3Year = HNO3Daily::where('Day', '<', date("Y-m-t", strtotime(date("Y-m-d"))) )
                            ->where('Day', '>=', date("Y").'-01-01' )->get();

        $spec     = HNO3Spec::orderBy('created_at', 'desc')->first();

        $resultData = array();
        $resultTimeLabe = array();

        foreach($HNO3 as $item)
        {
            array_push($resultData, $item->HNO3);
            array_push($resultTimeLabe, $item->date_time);
        }

        //當月累積
        $resultHNO3Month = 0;
        foreach($HNO3Daily as $day)
        {
            $resultHNO3Month += $day->HNO3;
        }

        //當年累積
        $resultHNO3Year = 0;
        foreach($HNO3Year as $day)
        {
            $resultHNO3Year += $day->HNO3;
        }

        $data = [
            'HNO3'     => json_encode($resultData),
            'TLable'   => json_encode($resultTimeLabe),
            'HNO3Month'=> $resultHNO3Month,
            'HNO3Year' => $resultHNO3Year,
            'Spec'     => $spec
        ];

        return view('hno3')->with('DATA', $data);
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

        $HNO3 = HNO3::where('date_time', '<=' , $end)
                  ->where('date_time', '>=' , $start)->get();

        $data = [
            'HNO3' => $HNO3
        ];
        return view('hno3report')->with('DATA', $data);
    }

    public function showChart(Request $req)
    {
        $spec     = HNO3Spec::orderBy('created_at', 'desc')->first();
        $resultData = array();
        $resultTimeLabe = array();
        
        $chartType = $req->chart_type;

        if($chartType == 'day')
        {
            $HNO3 = HNO3::where('date_time', '<=' , date('y-m-d', strtotime('+2 days')))
            ->where('date_time', '>=' , date('y-m-d', strtotime('+0 days')))->get();

            foreach($HNO3 as $item)
            {
                array_push($resultData, $item->HNO3);
                array_push($resultTimeLabe, $item->date_time);
            }
        }
        elseif($chartType == 'month')
        {
            $HNO3 = HNO3Daily::where('Day', '<', date("Y-m-t", strtotime(date("Y-m-d"))) )
            ->where('Day', '>=', date("Y-m-01", strtotime(date("Y-m-d"))) )->get();

            foreach($HNO3 as $item)
            {
                array_push($resultData, $item->HNO3);
                array_push($resultTimeLabe, $item->Day);
            }
        }
        else
        {
            $HNO3_01 = HNO3Year::where('Month', '=', '1' )->get()->sum('HNO3');
            $HNO3_02 = HNO3Year::where('Month', '=', '2' )->get()->sum('HNO3');
            $HNO3_03 = HNO3Year::where('Month', '=', '3' )->get()->sum('HNO3');
            $HNO3_04 = HNO3Year::where('Month', '=', '4' )->get()->sum('HNO3');
            $HNO3_05 = HNO3Year::where('Month', '=', '5' )->get()->sum('HNO3');
            $HNO3_06 = HNO3Year::where('Month', '=', '6' )->get()->sum('HNO3');
            $HNO3_07 = HNO3Year::where('Month', '=', '7' )->get()->sum('HNO3');
            $HNO3_08 = HNO3Year::where('Month', '=', '8' )->get()->sum('HNO3');
            $HNO3_09 = HNO3Year::where('Month', '=', '9' )->get()->sum('HNO3');
            $HNO3_10 = HNO3Year::where('Month', '=', '10' )->get()->sum('HNO3');
            $HNO3_11 = HNO3Year::where('Month', '=', '11' )->get()->sum('HNO3');
            $HNO3_12 = HNO3Year::where('Month', '=', '12' )->get()->sum('HNO3');

            $resultData     = [$HNO3_01, $HNO3_02, $HNO3_03, $HNO3_04, $HNO3_05, $HNO3_06,
                               $HNO3_07, $HNO3_08, $HNO3_09, $HNO3_10, $HNO3_11, $HNO3_12];
            $resultTimeLabe = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        }


        $data = [
            'HNO3'     => json_encode($resultData),
            'TLable'   => json_encode($resultTimeLabe),
            'Spec'     => $spec
        ];

        return view('hno3chart')->with('DATA', $data);
    }

    public function setSpecPage()
    {
        return view('hno3spec');
    }

    public function submitSpec(Request $req)
    {
        $HNO3Spec = new HNO3Spec;
        $HNO3Spec->top = $req->input('top');
        $HNO3Spec->bottom = $req->input('bottom');
        $HNO3Spec->save();
        
        return redirect()->back();
    }
}
