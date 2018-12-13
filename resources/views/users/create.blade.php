@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Создание пользователя</h2>
        </div>

        <div class="col-12 p-0">
            @include('users._form', ['formType' => 'create'])
        </div>
    </div>

@endsection