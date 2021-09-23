@extends('layouts.app')

@section('content')

<h2>HF報表</h2>
<div class="panel panel-default">
    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{route('hf_repor')}}" method="GET"  style="padding: 15px">
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
                <th scope="col">HF</th>
                <th scope="col">Date Time</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1 ?>
                @foreach ($DATA['HF'] as $item)
                <tr>
                <td>{{$i}}</td>
                <td>{{$item->HF}}</td>
                <td>{{$item->datetime}}</td>
                </tr>
                <?php $i++ ?>
                @endforeach
                
                
            </tbody>
        </table>
    </div>
</div>
@endsection
