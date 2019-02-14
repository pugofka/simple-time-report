@extends('layouts.app')

@section('content')
    <div class="row mt-5">
        <div class="col-12">
            @if (auth()->check())
                @if (auth()->user()->isAdmin())
                    <a href="{{route('reports.all')}}" class="btn btn-dark">Назад</a>
                @else
                    <a href="{{route('reports.index')}}" class="btn btn-dark">Назад</a>
                @endif
            @endif

        </div>
        
        <div class="col-12 mt-5 mb-5">
            <h2>Редактирование отчета</h2>
        </div>

        <div class="col-12 p-0">
            @include('reports._form')
        </div>
    </div>

@endsection