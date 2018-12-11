@extends('layouts.app')

@section('content')
    <h2>Пользователи</h2>

    <ul class="list-group list-group-flush">
        <li class="list-group-item">Sergeev</li>
        <li class="list-group-item">Liubimov</li>
        <li class="list-group-item">Karmov</li>
        <li class="list-group-item">Kvostov</li>
        <li class="list-group-item">Bulgar</li>
    </ul>

    @include('admin._form', ['formType' => 'create'])
@endsection