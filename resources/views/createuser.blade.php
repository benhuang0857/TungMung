@extends('layouts.app')

@section('content')
<h2>創建用戶</h2>

<div class="panel panel-default">
    <div class="panel-body">
        <form method="POST" action="{{route('createuser')}}" style="padding: 10px">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="user-name">員工姓名</label>
                <input id="user-name" class="form-control" name="user-name" type="text" placeholder="Name">
            </div>
            <div class="form-group row">
                <label for="user-email1 ">員工Email</label>
                <input class="form-control" id="user-email1" name="email" type="email" placeholder="Enter email">
            </div>
            <div class="form-group row">
                <label for="employeeid ">員工工號</label>
                <input id="employeeid" class="form-control" name="employeeid" type="text" placeholder="Employeeid">
            </div>
            <div class="form-group row">
                <label for="dept ">員工部門</label>
                <input id="dept" class="form-control" name="dept" type="text" placeholder="Department">
            </div>
            <div class="form-group row">
                <label for="password">設定密碼</label>
                <input id="password" class="form-control" name="password" type="password" placeholder="Password">
            </div>
            <div class="form-group row">
                <label for="user-status">帳號狀態</label>
                <select id="user-status" class="form-control" name="user-status">
                    <option value="ok">啟用</option>
                    <option value="ng">停用</option>
                </select>
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-primary btn-lg btn-block">送出</button>
            </div>
        </form>
    </div>
</div>

@endsection
