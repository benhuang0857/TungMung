<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\HF;
use DB;

class HFController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $HNO3 = HF::where('created_at', '<', '2021-07-30 13:00:00')->get();
        $resultData = array();

        foreach($HNO3 as $item)
        {
            array_push($resultData, $item->capacity);
        }

        return view('hf')->with('HF', json_encode($resultData));
    }
}
