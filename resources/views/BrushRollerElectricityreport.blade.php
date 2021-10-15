@extends('layouts.app')

@section('content')

<h2>刷輥電流報表</h2>
<div class="panel panel-default">
    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{route('brushrollerelectricity_report')}}" method="GET"  style="padding: 15px">
            <div class="form-group row">
                <input type="date" class="form-control" id="date" name="start">
            </div>
            <div class="form-group row">
                <input type="date" class="form-control" id="date" name="end">
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-primary btn-lg btn-block">篩選</button>
            </div>
        </form>
        <button class="btn btn-primary btn-lg btn-block" onclick="ExportToExcel('xlsx')">輸出EXCEL</button>
        <table class="table" id="tbl_exporttable_to_xls">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">電流01</th>
                <th scope="col">電流02</th>
                <th scope="col">電流03</th>
                <th scope="col">電流04</th>
                <th scope="col">電流05</th>
                <th scope="col">電流06</th>
                <th scope="col">Date Time</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1 ?>
                @foreach ($DATA['Electricity'] as $item)
                <tr>
                <td>{{$i}}</td>
                <td>{{$item->converter1}}</td>
                <td>{{$item->converter2}}</td>
                <td>{{$item->converter3}}</td>
                <td>{{$item->converter4}}</td>
                <td>{{$item->converter5}}</td>
                <td>{{$item->converter6}}</td>
                <td>"{{$item->date_time}}"</td>
                </tr>
                <?php $i++ ?>
                @endforeach
                
                
            </tbody>
        </table>
    </div>
</div>
@endsection
