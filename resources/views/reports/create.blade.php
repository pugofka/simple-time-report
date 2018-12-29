@extends('layouts.app')

@section('content')
    <div class="row mt-5">
        <div class="col-12">
            <a href="{{route('reports.index')}}" class="btn btn-dark">Назад</a>
        </div>

        <div class="col-12 mt-5">
            <h2>Создание отчета</h2>
        </div>

        <div class="col-12 p-0">
            @include('reports._form', ['formType' => 'create'])
        </div>
    </div>

@endsection