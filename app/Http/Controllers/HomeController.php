<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    #會員登入後的頁面
    #主要呈現所有會員Table
    public function index()
    {
        $users = User::paginate(15);
        $data = [
            'status' => ['ok', 'ng'],
            'users' => $users
        ];
        return view('home')->with('data', $data);
    }

    #搜尋特定會員
    public function filter(Request $req)
    {
        $name = $req->input('user-name');
        $status = $req->input('user-status');

        $users = User::paginate(15);

        if($name != NULL && $status != NULL)
        {
            $users = User::where('name', $name)->where('status', $status)->paginate(15);
        }
        elseif($name != NULL && $status == NULL)
        {
            $users = User::where('name', $name)->paginate(15);
        }
        elseif($name == NULL && $status != NULL)
        {
            $users = User::where('status', $status)->paginate(15);
        }
        else
        {
            $users = User::paginate(15);
        }

        $data = [
            'status' => ['ok', 'ng'],
            'users' => $users
        ];

        return view('home')->with('data', $data);
    }

    public function getUserByID($id)
    {
        $user = User::where('id', $id)->first();
        $data = [
            'status' => $user->status,
            'user' => $user
        ];

        return view('profile')->with('data', $data);
    }

    public function createUserPage()
    {
        return view('createuser');
    }

    public function createUser(Request $req)
    {
        $user = new User();

        $name = $req->input('user-name');
        $email = $req->input('email');
        $employeeid = $req->input('employeeid');
        $dept = $req->input('dept');
        $status = $req->input('user-status');
        $password = bcrypt($req->input('password'));
        
        $user->name         = $name;
        $user->email        = $email;
        $user->employeeid   = $employeeid;
        $user->dept         = $dept;
        $user->status       = $status;
        $user->password     = $password;
        $user->save();

        return redirect()->back();
    }
}
