<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\HNO3;
use App\HNO3Daily;
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
            'HNO3Year' => $resultHNO3Year
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
}
