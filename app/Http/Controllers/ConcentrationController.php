<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Concentration;
use DB;

class ConcentrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $Concentration = Concentration::where('created_at', '<', '2021-07-30 13:00:00')->get();
        $resultData = array();

        foreach($Concentration as $item)
        {
            array_push($resultData, $item->capacity);
        }

        return view('Concentration')->with('Concentration', json_encode($resultData));
    }
}
