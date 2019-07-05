@extends('layouts.app')

@section('content')
    <div class="row mt-5">
        <div class="col-12">
            <a href="{{route('reports.index')}}" class="btn btn-dark">Назад</a>
        </div>


        <div class="col-12 mt-5 mb-5">
            <h2>Редактирование отчета</h2>
            <p class="m-0">{{$report->report_start_date}} - {{$report->report_end_date}}</p>
        </div>

        <div class="col-12 p-0">
            @include('reports._form')
        </div>
    </div>

@endsection