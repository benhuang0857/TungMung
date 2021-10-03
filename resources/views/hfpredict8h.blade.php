@extends('layouts.app')

@section('content')

<h2>HF區間濃度預估</h2>
<div class="panel panel-default">
    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif  

        <form action="{{route('hf_predict_8h')}}" method="GET"  style="padding: 15px">
            <div class="form-group row">
                <label for="chart_type">輸入C0</label>
                <input type="number" class="form-control" name="C0" step="0.0001" placeholder="0.0">
                <label for="chart_type">選擇Line</label>
                <select id="tanknum" class="form-control" name="tanknum">
                    <option value="tank11">Tank 1.1</option>
                    <option value="tank12">Tank 1.2</option>
                    <option value="tank22">Tank 2.2</option>
                </select>
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-primary btn-lg btn-block">篩選</button>
            </div>
        </form>
    </div>
</div>

<div class="row" style="padding: 20px; font-size:15px">
    <div class="col-sm-6">
        線速：{{$DATA['HNO3Setting']->line_speed}}<br>
        版寬：{{$DATA['HNO3Setting']->board_width}}<br>
        添加時間：{{$DATA['HNO3Setting']->add_time}}<br>
        K1：{{$DATA['HNO3Setting']->K1}}<br>
        K2：{{$DATA['HNO3Setting']->K2}}<br>
        K3：{{$DATA['HNO3Setting']->K3}}<br>
    </div>
    <div class="col-sm-6">
        N'：{{$DATA['HNO3Setting']->N_plus}}<br>
        W'：{{$DATA['HNO3Setting']->W_plus}}<br>
        F'：{{$DATA['HNO3Setting']->F_plus}}<br>
        V0：{{$DATA['HNO3Setting']->V0}}<br>
    </div>
</div>

<div style="overflow: overlay;">
    <canvas id="canvas" height="1500" width="2200" style="margin: 10px"></canvas>
</div>

<form style="display: none">
    <input id="HNO3" type="text" value="{{$DATA['TankResult']}}">
    <input id="TLable" type="text" value="{{$DATA['TLable']}}">
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
