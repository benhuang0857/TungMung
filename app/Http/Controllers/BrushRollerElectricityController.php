<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ConverterView;
use App\ElectricitySpec;
use DB;

class BrushRollerElectricityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ConverterView = ConverterView::where('date_time', '<=' , date('y-m-d', strtotime('+2 days')))
                    ->where('date_time', '>=' , date('y-m-d', strtotime('+0 days')))->get();

        $spec   = ElectricitySpec::orderBy('created_at', 'desc')->first();

        $ConverterViewLast = ConverterView::first();

        $resultData01 = array();
        $resultData02 = array();
        $resultData03 = array();
        $resultData04 = array();
        $resultData05 = array();
        $resultData06 = array();
        $resultTimeLabe = array();

        foreach($ConverterView as $item)
        {
            array_push($resultData01, $item->converter1);
            array_push($resultData02, $item->converter2);
            array_push($resultData03, $item->converter3);
            array_push($resultData04, $item->converter4);
            array_push($resultData05, $item->converter5);
            array_push($resultData06, $item->converter6);
            array_push($resultTimeLabe, $item->date_time);
        }

        $data = [
            'Last'           => $ConverterViewLast,
            'Converter1'     => json_encode($resultData01),
            'Converter2'     => json_encode($resultData02),
            'Converter3'     => json_encode($resultData03),
            'Converter4'     => json_encode($resultData04),
            'Converter5'     => json_encode($resultData05),
            'Converter6'     => json_encode($resultData06),
            'TLable'         => json_encode($resultTimeLabe),
            'Spec'           => $spec
        ];

        return view('BrushRollerElectricity')->with('DATA', $data);
    }

    public function showReportDay(Request $req)
    {
        $start = $req->start;
        $end = $req->end;

        if($start == null || $end == null)
        {
            $start = date('Y-m-d');
            $end = date('Y-m-d');
        }

        $Electricity = ConverterView::where('date_time', '>=' , $start.' 00:00:00')
                  ->where('date_time', '<=' , $end.' 23:59:59')->get();

        $data = [
            'Electricity' => $Electricity
        ];
        return view('BrushRollerElectricityreport')->with('DATA', $data);
    }

    public function setSpecPage()
    {
        $ELESpec = DB::table('electricity_spec')->orderBy('created_at', 'desc')->first();

        if($ELESpec != null)
        {
            $data = [
                'top' => $ELESpec->top,
                'bottom' => $ELESpec->bottom,
            ];
        }
        else
        {
            $data = [
                'top' => 0,
                'bottom' => 0,
            ];
        }
        
        return view('electricityspec')->with('DATA', $data);
    }

    public function submitSpec(Request $req)
    {
        $ELESpec = new ElectricitySpec;
        $ELESpec->top = $req->input('top');
        $ELESpec->bottom = $req->input('bottom');
        $ELESpec->save();
        
        return redirect()->back();
    }
}
