@extends('layouts.app')

@section('content')
<h2>編輯用戶</h2>

<div class="panel panel-default">
    <div class="panel-body">
        <form method="GET" style="padding: 10px">
            <div class="form-group row">
                <label for="user-name">員工姓名</label>
                <input id="user-name" class="form-control" name="user-name" type="text" value="{{$data['user']->name}}" placeholder="Name">
            </div>
            <div class="form-group row">
                <label for="user-email1 ">員工Email</label>
                <input type="email" class="form-control" id="user-email1" aria-describedby="emailHelp" value="{{$data['user']->email}}" placeholder="Enter email">
            </div>
            <div class="form-group row">
                <label for="employeeid ">員工工號</label>
                <input id="employeeid" class="form-control" name="employeeid" type="text" value="{{$data['user']->employeeid}}" placeholder="Employeeid">
            </div>
            <div class="form-group row">
                <label for="dept ">員工部門</label>
                <input id="dept" class="form-control" name="dept" type="text" value="{{$data['user']->dept}}" placeholder="Department">
            </div>
            <div class="form-group row">
                <label for="user-status">帳號狀態</label>
                <select id="user-status" class="form-control" name="user-status">
                    @if ($data['status'] == 'ok')
                    <option value="ok" selected>ok</option>
                    <option value="ng">ng</option>
                    @else
                    <option value="ok">ok</option>
                    <option value="ng" selected>ng</option>
                    @endif
                </select>
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Search</button>
            </div>
        </form>
    </div>
</div>

@endsection
