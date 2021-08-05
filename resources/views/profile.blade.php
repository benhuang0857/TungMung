@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="GET" style="padding: 10px">
                        <div class="form-group row">
                            <label for="user-name">Name</label>
                            <input id="user-name" class="form-control" name="user-name" type="text" value="{{$data['user']->name}}" placeholder="Name">
                        </div>
                        <div class="form-group row">
                            <label for="user-email1 ">Email</label>
                            <input type="email" class="form-control" id="user-email1" aria-describedby="emailHelp" value="{{$data['user']->email}}" placeholder="Enter email">
                        </div>
                        <div class="form-group row">
                            <label for="employeeid ">employeeid</label>
                            <input id="employeeid" class="form-control" name="employeeid" type="text" value="{{$data['user']->employeeid}}" placeholder="Employeeid">
                        </div>
                        <div class="form-group row">
                            <label for="dept ">dept</label>
                            <input id="dept" class="form-control" name="dept" type="text" value="{{$data['user']->dept}}" placeholder="Department">
                        </div>
                        <div class="form-group row">
                            <label for="user-status">status</label>
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
        </div>
    </div>
</div>
@endsection
