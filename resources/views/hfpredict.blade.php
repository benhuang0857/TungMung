@extends('layouts.app')

@section('content')

<h2>HF濃度分析</h2>
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
                <th scope="col" style="width:80px">製程</th>
                <th scope="col">Tank1.1 HNO3</th>
                <th scope="col">Tank1.1 H2O</th>
                <th scope="col">Tank1.1 HF</th>
                <th scope="col">Tank1.2 HNO3</th>
                <th scope="col">Tank1.2 H2O</th>
                <th scope="col">Tank1.2 HF</th>
                <th scope="col">Tank2.2 HNO3</th>
                <th scope="col">Tank2.2 H2O</th>
                <th scope="col">Tank2.2 HF</th>
                <th scope="col">報表</th>
                </tr>
            </thead>
            <tbody>
                <td>1</td>
                <td>MAT-{{$DATA['Tank_Last']->mat}}</td>
                <!--Tank11-->
                @if ($DATA['Tank_Last']->tank11_hno3 == null)
                <td>--</td>
                @else
                <td>{{$DATA['Tank_Last']->tank11_hno3}}</td>
                @endif

                @if ($DATA['Tank_Last']->tank11_h2o == null)
                <td>--</td>
                @else
                <td>{{$DATA['Tank_Last']->tank11_h2o}}</td>
                @endif

                @if ($DATA['Tank_Last']->tank11_hf == null)
                <td>--</td>
                @else
                <td>{{$DATA['Tank_Last']->tank11_hf}}</td>
                @endif

                <!--Tank12-->
                @if ($DATA['Tank_Last']->tank12_hno3 == null)
                <td>--</td>
                @else
                <td>{{$DATA['Tank_Last']->tank12_hno3}}</td>
                @endif

                @if ($DATA['Tank_Last']->tank12_h2o == null)
                <td>--</td>
                @else
                <td>{{$DATA['Tank_Last']->tank12_h2o}}</td>
                @endif

                @if ($DATA['Tank_Last']->tank12_hf == null)
                <td>--</td>
                @else
                <td>{{$DATA['Tank_Last']->tank12_hf}}</td>
                @endif

                <!--Tank22-->
                @if ($DATA['Tank_Last']->tank22_hno3 == null)
                <td>--</td>
                @else
                <td>{{$DATA['Tank_Last']->tank22_hno3}}</td>
                @endif

                @if ($DATA['Tank_Last']->tank22_h2o == null)
                <td>--</td>
                @else
                <td>{{$DATA['Tank_Last']->tank22_h2o}}</td>
                @endif

                @if ($DATA['Tank_Last']->tank22_hf == null)
                <td>--</td>
                @else
                <td>{{$DATA['Tank_Last']->tank22_hf}}</td>
                @endif
                
                <td><a href="/hf_predict_repor">報表</a></td>
            </tbody>
        </table>

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
