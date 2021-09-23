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

        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">設備位置</th>
                <th scope="col">設備名稱</th>
                <th scope="col">即時用量(每15分)</th>
                <th scope="col">月累積</th>
                <th scope="col">年累積</th>
                <th scope="col">分析圖</th>
                <th scope="col">警示設定</th>
                <th scope="col">報表</th>
                </tr>
            </thead>
            <tbody>
                <td>1</td>
                <td>HNO3設備</td>
                <td>HNO3設備</td>
                <td id="15m">尚無資料</td>
                <td>{{$DATA['HNO3Month']}}</td>
                <td>{{$DATA['HNO3Year']}}</td>
                <td><a href="#">分析圖</a></td>
                <td><a href="#">分析圖</a></td>
                <td><a href="/hno3_repor">報表</a></td>
            </tbody>
        </table>
    </div>
</div>

<div style="overflow: overlay;">
    <canvas id="canvas" height="1500" width="2200" style="margin: 10px"></canvas>
</div>

<form style="display: none">
    <input id="HNO3" type="text" value="{{$DATA['HNO3']}}">
    <input id="TLable" type="text" value="{{$DATA['TLable']}}">
</form>

<script>
	var HNO3 = $('#HNO3').val();
    var TLable = $('#TLable').val();

    var HNO3str = HNO3.replace('[', '');
    HNO3str = HNO3str.replace(']', '');
    HNO3str = HNO3str.replaceAll('\"', '');
    var HNO3Arr = HNO3str.split(',');

    document.getElementById("15m").textContent = HNO3Arr[HNO3Arr.length-1];

    var TLablestr = TLable.replace('[', '');
    TLablestr = TLablestr.replace(']', '');
    TLablestr = TLablestr.replaceAll('\"', '');
    var TLableArr = TLablestr.split(',');

    var ctx = document.getElementById('canvas');
    var frameworks = TLableArr; 

    var spec = Array.from({length: HNO3Arr.length}, (_, index) => 0.2);

    console.log(spec);

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: frameworks,
            datasets: [
                {
                    label: 'HNO3',
                    borderColor: "blue",
                    borderWidth: 1,
                    data: HNO3Arr
                },
                {
                    label: 'SPEC',
                    borderColor: "red",
                    borderWidth: 1,
                    data: spec
                }
            ],
        }
    });
</script>
@endsection
