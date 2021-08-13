<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\BrushRollerElectricity;
use DB;

class BrushRollerElectricityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $BrushRollerElectricity = BrushRollerElectricity::where('created_at', '<', '2021-07-30 13:00:00')->get();
        $resultData = array();

        foreach($BrushRollerElectricity as $item)
        {
            array_push($resultData, $item->capacity);
        }

        return view('BrushRollerElectricity')->with('BrushRollerElectricity', json_encode($resultData));
    }
}
