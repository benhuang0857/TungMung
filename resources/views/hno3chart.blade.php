@extends('layouts.app')

@section('content')

<h2>HNO3監管用量Chart</h2>
<div class="panel panel-default">
    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{route('hno3showchart')}}" method="GET"  style="padding: 15px">
            <div class="form-group row">
                <label for="chart_type">選擇區間</label>
                <select id="chart_type" class="form-control" name="chart_type">
                    <option value="day">當日</option>
                    <option value="month">當月</option>
                    <option value="year">今年度</option>
                </select>
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-primary btn-lg btn-block">篩選</button>
            </div>
        </form>

    </div>
</div>

<div style="overflow: overlay;">
    <canvas id="canvas" height="1500" width="2200" style="margin: 10px"></canvas>
</div>

<form style="display: none">
    <input id="HNO3" type="text" value="{{$DATA['HNO3']}}">
    <input id="TLable" type="text" value="{{$DATA['TLable']}}">
    <?php
        try {
    ?>
    <input id="Top" type="text" value="{{$DATA['Spec']->top}}">
    <input id="Bottom" type="text" value="{{$DATA['Spec']->bottom}}">
    <?php
        } catch (\Throwable $th) {
            //throw $th;
        }
    ?>
</form>

<script>
	var HNO3 = $('#HNO3').val();
    var TLable = $('#TLable').val();
    var Top = $('#Top').val();
    var Bottom = $('#Bottom').val();

    var HNO3str = HNO3.replace('[', '');
    HNO3str = HNO3str.replace(']', '');
    HNO3str = HNO3str.replaceAll('\"', '');
    var HNO3Arr = HNO3str.split(',');

    var TLablestr = TLable.replace('[', '');
    TLablestr = TLablestr.replace(']', '');
    TLablestr = TLablestr.replaceAll('\"', '');
    var TLableArr = TLablestr.split(',');

    var ctx = document.getElementById('canvas');
    var frameworks = TLableArr; 

    var top_spec = Array.from({length: HNO3Arr.length}, (_, index) => Top);
    var bottom_spec = Array.from({length: HNO3Arr.length}, (_, index) => Bottom);

    if(Top != null)
    {
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
                        label: 'Top Spec',
                        borderColor: "red",
                        borderWidth: 1,
                        data: top_spec
                    },
                    {
                        label: 'Bottom Spec',
                        borderColor: "red",
                        borderWidth: 1,
                        data: bottom_spec
                    }
                ],
            }
        });
    }
    else
    {
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
                    }
                ],
            }
        });
    }

</script>
@endsection
