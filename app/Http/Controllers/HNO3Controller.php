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
        $output = "";

        $HNO3 = HNO3::all();
        $all_machine_name = DB::select('select distinct(machine_name) from hno3');
        $all_location = DB::select('select distinct(location) from hno3');

        foreach($all_machine_name as $name)
        {
            $value = DB::select('select capacity from hno3 as T where T.machine_name="'.$name->machine_name.'"');
            
            $result = "";
            foreach($value as $data)
            {
                $result .= $data->capacity.',';
            }
            
            $output .= '<input class="HNO3" type="text" value="'.$result.'">';
        }

        $resultdata = [
            'output' => $output,
            'all_machine_name' => $all_machine_name,
            'all_location' => $all_location
        ];
        return view('hno3')->with('Output', $resultdata);
    }

    public function getOne($name)
    {
        $machine_name = $name;
        $output = "";

        $value = HNO3::where('machine_name', $machine_name)->get();
            
        $result = "";
        foreach($value as $data)
        {
            $result .= $data->capacity.',';
        }
        
        $output .= '<input class="HNO3" type="text" value="'.$result.'">';

        $resultdata = [
            'name' => $name,
            'output' => $output
        ];
        return view('onehno3')->with('Output', $resultdata);
    }
}
