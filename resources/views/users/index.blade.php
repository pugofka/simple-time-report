@extends('layouts.app')

@section('content')

    <div class="row mt-5">
        <div class="col-12">
            <h1>Пользователи</h1>
        </div>

        <div class="col-12">
            <ul class="list-group list-group-flush">
                @foreach ($users as $user)
                    <li class="list-group-item">
                        <span>{{$user->name}}</span>
                        <span>{{$user->last_name}}</span>
                        <span>{{$user->email}}</span>
                        <span>{{$user->role}}</span>
                        <a href="/users/{{$user->id}}">Редактировать</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-12 mt-5">
            <a href="/users/create" class="btn btn-success">Добавить</a>
        </div>
    </div>

@endsection