@extends('layouts.app')

@section('content')
<h2>使用者</h2>

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

<div class="panel panel-default">
    <div class="panel-body">
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
                    <td>
                        @if ($user->status == 'ok')
                            <i class="fa fa-check-circle" style="color: green" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-times" style="color: red" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td><a class="btn btn-primary" href="/user/edit/{{$user->id}}">管理</a></td>
                    <td><a class="btn btn-danger" href="/user/delete/{{$user->id}}">刪除</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data['users']->links() }}
    </div>
</div>
@endsection
