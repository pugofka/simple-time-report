@extends('layouts.app')

@section('content')
    <div class="row mt-5">
        <div class="col-12">
            <h1>Отчеты</h1>
        </div>

        <div class="col-12">
            {!! Form::open(['url' => route('reports.all'), 'class'=>'form', 'method' => 'get']) !!}
            <div class="form-group">
                {{ Form::label('role', 'Пользователь', ['class' => 'col-md-3 control-label p-0']) }}
                <div class="col-md-4 p-0">
                    <select name="user" id="role" class="form-control" required>
                        <option value="all" @if(request()->user == 'all') selected @endif>Все</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}" @if(request()->user == $user->id) selected @endif>{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 p-0">
                    {{ Form::submit('Выбрать', ['class' => 'btn btn-success']) }}
                </div>
            </div>
            {!! Form::close() !!}
        </div>

        <div class="col-12">
            <div class="table-responsive-sm">
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <td>Имя</td>
                        <td>С</td>
                        <td>По</td>
                        <td>Плановое рабочее время</td>
                        <td>Фактическое рабочее время</td>
                        <td>Рабочие часы</td>
                        <td>Эффективные рабочие часы</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{$report->author}}</td>
                            <td>{{$report->report_start_date}}</td>
                            <td>{{$report->report_end_date}}</td>
                            <td>{{$report->plane_hours}}</td>
                            @if($report->fact_hours < $report->plane_hours)
                                <td class="text-danger">{{$report->fact_hours}}</td>
                            @else
                                <td>{{$report->fact_hours}}</td>
                            @endif
                            <td>{{$report->week_hours}}</td>
                            <td>{{$report->effective_hours}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection