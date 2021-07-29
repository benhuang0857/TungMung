<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\HNO3;
use DB;

class HNO3Controller extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $HNO3 = HNO3::where('created_at', '<', '2021-07-30 13:00:00')->get();
        $resultData = array();

        foreach($HNO3 as $item)
        {
            array_push($resultData, $item->capacity);
        }

        return view('hno3')->with('HNO3', json_encode($resultData));
    }

    // public function getData(Type $var = null)
    // {
    //     # code...
    // }
}
