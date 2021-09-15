@extends('layouts.app')

@section('content')
<h2>刷輥電流</h2>
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
                <tr>
                    <td>1</td>
                    <td>刷輥電流設備</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">報表</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>刷輥電流設備</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">報表</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>刷輥電流設備</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">報表</a></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>刷輥電流設備</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">報表</a></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>刷輥電流設備</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">報表</a></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>刷輥電流設備</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td>尚無資料</td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">分析圖</a></td>
                    <td><a href="#">報表</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div style="overflow: overlay;">
    <canvas id="canvas" height="400" width="2200" style="margin: 10px"></canvas>
</div>

<form style="display: none">
    <input id="Converter1" type="text" value="{{$DATA['Converter1']}}">
    <input id="Converter2" type="text" value="{{$DATA['Converter2']}}">
    <input id="Converter3" type="text" value="{{$DATA['Converter3']}}">
    <input id="Converter4" type="text" value="{{$DATA['Converter4']}}">
    <input id="Converter5" type="text" value="{{$DATA['Converter5']}}">
    <input id="Converter6" type="text" value="{{$DATA['Converter6']}}">
    <input id="TLable" type="text" value="{{$DATA['TLable']}}">
</form>

<script>
    var TLable = $('#TLable').val();
    var TLablestr = TLable.replace('[', '');
    TLablestr = TLablestr.replace(']', '');
    TLablestr = TLablestr.replaceAll('\"', '');
    var TLableArr = TLablestr.split(',');

    var Converter1 = $('#Converter1').val();
    var Converter1str = Converter1.replace('[', '');
    Converter1str = Converter1str.replace(']', '');
    Converter1str = Converter1str.replaceAll('\"', '');
    var Converter1Arr = Converter1str.split(',');

    var Converter2 = $('#Converter2').val();
    var Converter2str = Converter2.replace('[', '');
    Converter2str = Converter2str.replace(']', '');
    Converter2str = Converter2str.replaceAll('\"', '');
    var Converter2Arr = Converter2str.split(',');

    var Converter3 = $('#Converter3').val();
    var Converter3str = Converter3.replace('[', '');
    Converter3str = Converter3str.replace(']', '');
    Converter3str = Converter3str.replaceAll('\"', '');
    var Converter3Arr = Converter3str.split(',');

    var Converter4 = $('#Converter4').val();
    var Converter4str = Converter4.replace('[', '');
    Converter4str = Converter4str.replace(']', '');
    Converter4str = Converter4str.replaceAll('\"', '');
    var Converter4Arr = Converter4str.split(',');

    var Converter5 = $('#Converter5').val();
    var Converter5str = Converter5.replace('[', '');
    Converter5str = Converter5str.replace(']', '');
    Converter5str = Converter5str.replaceAll('\"', '');
    var Converter5Arr = Converter5str.split(',');

    var Converter6 = $('#Converter6').val();
    var Converter6str = Converter6.replace('[', '');
    Converter6str = Converter6str.replace(']', '');
    Converter6str = Converter6str.replaceAll('\"', '');
    var Converter6Arr = Converter6str.split(',');

    var lineChartData = {
        labels : TLableArr,
        datasets : [
            {
                label: "Hourly dataset",
                fillColor : "rgba(200,187,205,0.2)",
                strokeColor : "rgba(200,187,205,1)",
                pointColor : "rgba(200,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
                data : Converter1Arr
            }
        ]
    };

    var newDataset = {
        label: "Hourly dataset",
        fillColor : "rgba(200,187,205,0.2)",
        strokeColor : "blue",
        pointColor : "rgba(200,187,205,1)",
        pointStrokeColor : "#fff", 
        pointHighlightFill : "#fff",
        pointHighlightStroke : "rgba(151,187,205,1)",
        data: Converter2Arr,
    };
    lineChartData.datasets.push(newDataset);

    var newDataset = {
        label: "Hourly dataset",
        fillColor : "rgba(200,187,205,0.2)",
        strokeColor : "yellow",
        pointColor : "rgba(200,187,205,1)",
        pointStrokeColor : "#fff", 
        pointHighlightFill : "#fff",
        pointHighlightStroke : "rgba(151,187,205,1)",
        data: Converter3Arr,
    };
    lineChartData.datasets.push(newDataset);

    var newDataset = {
        label: "Hourly dataset",
        fillColor : "rgba(200,187,205,0.2)",
        strokeColor : "green",
        pointColor : "rgba(200,187,205,1)",
        pointStrokeColor : "#fff", 
        pointHighlightFill : "#fff",
        pointHighlightStroke : "rgba(151,187,205,1)",
        data: Converter4Arr,
    };
    lineChartData.datasets.push(newDataset);

    var newDataset = {
        label: "Hourly dataset",
        fillColor : "rgba(200,187,205,0.2)",
        strokeColor : "red",
        pointColor : "rgba(200,187,205,1)",
        pointStrokeColor : "#fff", 
        pointHighlightFill : "#fff",
        pointHighlightStroke : "rgba(151,187,205,1)",
        data: Converter5Arr,
    };
    lineChartData.datasets.push(newDataset);

    var newDataset = {
        label: "Hourly dataset",
        fillColor : "rgba(200,187,205,0.2)",
        strokeColor : "black",
        pointColor : "rgba(200,187,205,1)",
        pointStrokeColor : "#fff",
        pointHighlightFill : "#fff",
        pointHighlightStroke : "rgba(151,187,205,1)",
        data: Converter6Arr,
    };
    lineChartData.datasets.push(newDataset);

	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx);
		myLine.Line(lineChartData, {
			responsive: true
		});
	} 

</script>
@endsection
