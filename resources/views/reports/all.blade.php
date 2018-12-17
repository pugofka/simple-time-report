@extends('layouts.app')

@section('content')
    <div class="row mt-5">
        <div class="col-12">
            <h1>Отчеты</h1>
        </div>

        <div class="col-12">
            <ul class="list-group">
                @foreach ($reports as $report)
                    <li class="list-group-item">
                        <span>{{$report->report_start_date}} - </span>
                        <span>{{$report->report_end_date}}</span>
                        <span>({{$report->plane_hours}}</span>
                        <span>{{$report->fact_hours}}</span>
                        <span>{{$report->week_hours}}</span>
                        <span>{{$report->effective_hours}})</span>
                        <span>{{$report->author}}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection