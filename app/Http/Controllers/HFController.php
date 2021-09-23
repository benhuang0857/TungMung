<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\HF;
use App\HFDaily;
use App\HFSpec;
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
