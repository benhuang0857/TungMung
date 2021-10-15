@extends('layouts.app')

@section('content')

<h2>HF監管用量Chart</h2>
<div class="panel panel-default">
    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{route('hfshowchart')}}" method="GET"  style="padding: 15px">
            <div class="form-group row">
                <label for="chart_type">選擇區間</label>
                <select id="chart_type" class="form-control" name="chart_type">
                    <option value="year">年度</option>
                    <option value="day">當日</option>
                    <option value="month">當月</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="The_Date">選擇時間:</label>
                <input type="text" id="The_Date" name="The_Date" class="yearpicker form-control" size="4">
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
    <input id="HF" type="text" value="{{$DATA['HF']}}">
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
	var HF = $('#HF').val();
    var TLable = $('#TLable').val();
    var Top = $('#Top').val();
    var Bottom = $('#Bottom').val();

    var HFstr = HF.replace('[', '');
    HFstr = HFstr.replace(']', '');
    HFstr = HFstr.replaceAll('\"', '');
    var HFArr = HFstr.split(',');

    var TLablestr = TLable.replace('[', '');
    TLablestr = TLablestr.replace(']', '');
    TLablestr = TLablestr.replaceAll('\"', '');
    var TLableArr = TLablestr.split(',');

    var ctx = document.getElementById('canvas');
    var frameworks = TLableArr; 

    var top_spec = Array.from({length: HFArr.length}, (_, index) => Top);
    var bottom_spec = Array.from({length: HFArr.length}, (_, index) => Bottom);

    if(Top != null)
    {
        var myChart = new Chart(ctx, {
        type: 'line',
            data: {
                labels: frameworks,
                datasets: [
                    {
                        label: 'HF',
                        borderColor: "blue",
                        borderWidth: 1,
                        data: HFArr
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
                        label: 'HF',
                        borderColor: "blue",
                        borderWidth: 1,
                        data: HFArr
                    }
                ],
            }
        });
    }

</script>

<script>
    $(".yearpicker").yearpicker();
    
    var target = $('#chart_type option:selected').val();

    $('#chart_type').change(function(){
        if($(this).val() == 'day'){
            $('#The_Date').prop('type', 'date');
            $('#The_Date').removeClass('yearpicker');
            $('.yearpicker-container').hide();
        }
        if($(this).val() == 'month'){
            $('#The_Date').prop('type', 'month');
            $('#The_Date').removeClass('yearpicker');
            $('.yearpicker-container').hide();
        }
        if($(this).val() == 'year'){
            $('#The_Date').addClass('yearpicker');
            $('#The_Date').prop('type', 'text');
            $('.yearpicker-container').show();
        }
    });
</script>

@endsection
