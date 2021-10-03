@extends('layouts.app')

@section('content')

<h2>HF濃度分析報表</h2>
<div class="panel panel-default">
    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{route('hf_predict_repor')}}" method="GET"  style="padding: 15px">
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
                <th scope="col">Tank1.1</th>
                <th scope="col">Tank1.2</th>
                <th scope="col">Tank2.2</th>
                <th scope="col">Date Time</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1 ?>
                @foreach ($DATA['HNO3'] as $item)
                <tr>
                <td>{{$i}}</td>
                <td>{{$item->tank11C0}}</td>
                <td>{{$item->tank12C0}}</td>
                <td>{{$item->tank22C0}}</td>
                <td>"{{$item->created_at}}"</td>
                </tr>
                <?php $i++ ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
