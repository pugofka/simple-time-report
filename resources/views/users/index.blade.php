@extends('layouts.app')

@section('content')

    <div class="row mt-5">
        <div class="col-12">
            <h1>Пользователи</h1>
        </div>

        <div class="col-12 mt-3">
            <div class="table-responsive-sm">
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <td>Имя</td>
                        <td>Фамилия</td>
                        <td>E-Mail</td>
                        <td>Роль</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->lastname}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role}}</td>
                            <td>
                                <a href="/users/{{$user->id}}/edit">Редактировать</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{route('users.create')}}" class="btn btn-success mt-3">Добавить</a>
        </div>
    </div>

@endsection