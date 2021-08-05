@extends('layouts.app')

@section('content')
<script data-require="jquery@*" data-semver="2.1.1" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script data-require="chart.js@0.2.0" data-semver="0.2.0" src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.js"></script>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="panel panel-default">
                <div class="panel-heading">HF監管用量</div>

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
                            <td>HF設備</td>
                            <td>10.0</td>
                            <td>尚無資料</td>
                            <td>尚無資料</td>
                            <td>尚無資料</td>
                            <td><a href="#">分析圖</a></td>
                            <td><a href="#">分析圖</a></td>
                            <td><a href="#">報表</a></td>
                        </tbody>
                    </table>

                    <div style="overflow: overlay;">
                        <canvas id="canvas" height="400" width="2200" style="margin: 10px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form style="display: none">
    <input id="HF" type="text" value="{{$HF}}">
</form>

<script>
var randomScalingFactor = function(){ return Math.round(Math.random()*256)};

    var HNO3 = $('#HF').val();
    var HNO3str = HNO3.replace('[', '');
    HNO3str = HNO3str.replace(']', '');
    var HNO3Arr = HNO3str.split(',');

    var lineChartData = {
        labels : ["00:15","00:30","00:45","01:00",
                "01:15","01:30","01:45","02:00",
                "02:15","02:30","02:45","02:00",
                "03:15","03:30","03:45","03:00",
                "04:15","04:30","04:45","04:00",
                "05:15","05:30","05:45","05:00",
                "06:15","06:30","06:45","06:00",
                "07:15","07:30","07:45","07:00",
                "08:15","08:30","08:45","08:00",
                "09:15","09:30","09:45","09:00",
                "10:15","10:30","10:45","11:00",
                "11:15","11:30","11:45","12:00",
                "12:15","12:30","12:45","13:00"],
        datasets : [
            {
                label: "Hourly dataset",
                fillColor : "rgba(200,187,205,0.2)",
                strokeColor : "rgba(200,187,205,1)",
                pointColor : "rgba(200,187,205,1)",
                pointStrokeColor : "#fff", 
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
                data : HNO3Arr
            }
        ]

    };
		
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx);
		myLine.Line(lineChartData, {
			responsive: true
		});
	} 

</script>
@endsection
