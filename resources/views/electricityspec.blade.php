@extends('layouts.app')

@section('content')
<h2>電流 SPEC 設定</h2>

<div class="panel panel-default">
    <div class="panel-body">
        <form method="GET" action="{{route('setting_elespec')}}" style="padding: 10px">
            <div class="form-group row">
                <label for="top">TOP Spec</label>
                <input id="top" class="form-control" name="top" value="{{$DATA['top']}}" type="text" placeholder="Top Spec">
            </div>
            <div class="form-group row">
                <label for="bottom">Bottom Spec</label>
                <input id="bottom" class="form-control" name="bottom" value="{{$DATA['bottom']}}" type="text" placeholder="Bottom Spec">
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-primary btn-lg btn-block">送出</button>
            </div>
        </form>
    </div>
</div>

@endsection
