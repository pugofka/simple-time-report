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
                            <span>{{$user->lastname}}</span>
                            <span>{{$user->email}}</span>
                            <span>{{$user->role}}</span>
                            <a href="/users/{{$user->id}}/edit">Редактировать</a>
                        </li>
                    @endforeach
                </ul>

                <a href="{{route('users.create')}}" class="btn btn-success mt-5">Добавить</a>
            </div>


    </div>

@endsection