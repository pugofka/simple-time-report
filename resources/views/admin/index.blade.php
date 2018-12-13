@extends('layouts.app')

@section('content')
    <h2>Пользователи</h2>

    <ul class="list-group list-group-flush">
        @foreach ($users as $user)
            <li class="list-group-item">
                <span>{{$user->name}}</span>
                <span>{{$user->email}}</span>
                <span>{{$user->role}}</span>
            </li>
        @endforeach
    </ul>




    @include('admin._form', ['formType' => 'create'])
@endsection