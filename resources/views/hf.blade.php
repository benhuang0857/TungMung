@extends('layouts.app')

@section('content')

<h2>HF監管用量</h2>
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
                <td>HF設備</td>
                <td>HF設備</td>
                <td id="15m">尚無資料</td>
                <td>{{$DATA['HFMonth']}}</td>
                <td>{{$DATA['HFYear']}}</td>
                <td><a href="#">分析圖</a></td>
                <td><a href="/hf_spec">設定</a></td>
                <td><a href="/hf_repor">報表</a></td>
            </tbody>
        </table>
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

    document.getElementById("15m").textContent = HFArr[HFArr.length-1];

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
                ]
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
                ]
            }
        });
    }
    

</script>
@endsection
