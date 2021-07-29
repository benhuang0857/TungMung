@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="GET" action="/home/filter" style="padding: 10px">
                        <div class="form-group row">
                            <input id="user-name" class="form-control" name="user-name" type="text" placeholder="Name">
                        </div>
                        <div class="form-group row">
                        <select id="user-status" class="form-control" name="user-status">
                            @foreach ($data['status'] as $status)
                            <option value="{{$status}}">{{$status}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Search</button>
                        </div>
                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">使用者/新增</th>
                            <th scope="col">員工編號</th>
                            <th scope="col">部門</th>
                            <th scope="col">狀態</th>
                            <th scope="col">管理</th>
                            <th scope="col">刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1?>
                            @foreach ($data['users'] as $user)
                            <tr>
                                <th scope="row">{{$i++}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->employeeid}}</td>
                                <td>{{$user->dept}}</td>
                                <td>{{$user->status}}</td>
                                <td><a href="/user/edit/{{$user->id}}">管理</a></td>
                                <td><a href="/user/delete/{{$user->id}}">刪除</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data['users']->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
