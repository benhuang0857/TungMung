@extends('layouts.app')

@section('content')

<h2>HNO3監管用量</h2>
<div class="panel panel-default">
    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>

<div>
    <canvas id="canvas" height="1500" width="2200" style="margin: 10px"></canvas>
</div>

<form style="display: none">
    <input id="tank11C0" type="text" value="{{$DATA['tank11C0']}}">
    <input id="tank12C0" type="text" value="{{$DATA['tank12C0']}}">
    <input id="tank22C0" type="text" value="{{$DATA['tank22C0']}}">
    <input id="TLable" type="text" value="{{$DATA['TLable']}}">
</form>

<script>
	var tank11C0 = $('#tank11C0').val();
    var tank12C0 = $('#tank12C0').val();
    var tank22C0 = $('#tank22C0').val();
    var TLable = $('#TLable').val();

    var tank11C0str = tank11C0.replace('[', '');
    tank11C0str = tank11C0str.replace(']', '');
    tank11C0str = tank11C0str.replaceAll('\"', '');
    var tank11Arr = tank11C0str.split(',');

    var tank12C0str = tank12C0.replace('[', '');
    tank12C0str = tank12C0str.replace(']', '');
    tank12C0str = tank12C0str.replaceAll('\"', '');
    var tank12Arr = tank12C0str.split(',');

    var tank22C0str = tank22C0.replace('[', '');
    tank22C0str = tank22C0str.replace(']', '');
    tank22C0str = tank22C0str.replaceAll('\"', '');
    var tank22Arr = tank22C0str.split(',');

    var TLablestr = TLable.replace('[', '');
    TLablestr = TLablestr.replace(']', '');
    TLablestr = TLablestr.replaceAll('\"', '');
    var TLableArr = TLablestr.split(',');

    var ctx = document.getElementById('canvas');
    var frameworks = TLableArr; 

    var myChart = new Chart(ctx, {
        type: 'line',
            data: {
                labels: frameworks,
                datasets: [
                    {
                        label: 'Tank 1.1',
                        borderColor: "blue",
                        borderWidth: 1,
                        data: tank11Arr
                    },
                    {
                        label: 'Tank 1.2',
                        borderColor: "red",
                        borderWidth: 1,
                        data: tank12Arr
                    },
                    {
                        label: 'Tank 2.2',
                        borderColor: "yellow",
                        borderWidth: 1,
                        data: tank22Arr
                    }
                ],
            }
        });

</script>
@endsection
