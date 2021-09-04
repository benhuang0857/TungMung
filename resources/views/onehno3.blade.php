@extends('layouts.app')

@section('content')

<h2>HNO3監管用量-{{$Output['name']}}</h2>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div style="overflow: overlay;">
    <canvas id="canvas" height="400" width="2200" style="margin: 10px"></canvas>
</div>

<div id="dp">
    {!!$Output['output']!!}
</div>

<script data-require="jquery@*" data-semver="2.1.1" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script data-require="chart.js@0.2.0" data-semver="0.2.0" src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.js"></script>

<script>
    var HNO3 = document.getElementsByClassName("HNO3");
    var chartArr = [];
    for(var i=0; i < HNO3.length; i++)
    {
        var value = HNO3[i].value;
        var tmp = value.split(',');
        chartArr[i] = tmp;
    }

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
                strokeColor : "red",
                pointColor : "rgba(200,187,205,1)",
                pointStrokeColor : "#fff", 
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
                data : chartArr[0],
            },
        ]
    };

    for(var j=1; j < HNO3.length; j++)
    {
        var newDataset = {
            label: "Hourly dataset",
            fillColor : "rgba(200,187,205,0.2)",
            strokeColor : "red",
            pointColor : "rgba(200,187,205,1)",
            pointStrokeColor : "#fff", 
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(151,187,205,1)",
            data: chartArr[j],
        };
        lineChartData.datasets.push(newDataset);
    }
    
</script>
<script>
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx);
		myLine.Line(lineChartData, {
			responsive: true
		});
	} 
</script>
@endsection
