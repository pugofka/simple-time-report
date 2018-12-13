@if (isset($user))
    {{ Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'put']) }}
@else
    {!! Form::open(['url' => route('user.store'), 'class'=>'form', 'method' => 'post']) !!}
@endif
<div class="form-group {{ $errors->has('name') ?  'has-error' : ''}}">
    {{ Form::label('name', 'Имя', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-9">
        {{ Form::text('name', null, ['class'=>'form-control']) }}
        @if ($errors->has('name'))
            <span class="help-block">{{  $errors->first('name') }}</span>
        @endif
    </div>
</div>

<div class="form-group {{ $errors->has('lastname') ?  'has-error' : ''}}">
    {{ Form::label('lastname', 'Фамилия', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-9">
        {{ Form::text('lastname', null, ['class'=>'form-control']) }}
        @if ($errors->has('lastname'))
            <span class="help-block">{{  $errors->first('lastname') }}</span>
        @endif
    </div>
</div>

<div class="form-group {{ $errors->has('email') ?  'has-error' : ''}}">
    {{ Form::label('email', 'E-Mail', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-9">
        {{ Form::text('email', null, ['class'=>'form-control']) }}
        @if ($errors->has('email'))
            <span class="help-block">{{  $errors->first('email') }}</span>
        @endif
    </div>
</div>

<div class="form-group">
    {{ Form::label('role', 'Роль', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-9">
        <select name="role" id="role" class="form-control" required>
            @if ($formType == 'edit')
                @if($role === "admin")
                    <option value="admin" selected>Админ</option>
                    <option value="user">Пользователь</option>
                @else
                    <option value="admin">Админ</option>
                    <option value="user" selected>Пользователь</option>
                @endif
            @else
                <option value="admin">Пользователь</option>
                <option value="user">Админ</option>
            @endif
        </select>
    </div>
</div>

<div class="form-group {{ $errors->has('plane_hours') ?  'has-error' : ''}}">
    {{ Form::label('plane_hours', 'Плановое рабочее время', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-9">
        {{ Form::number('plane_hours', null, ['class'=>'form-control']) }}
        @if ($errors->has('plane_hours'))
            <span class="help-block">{{  $errors->first('plane_hours') }}</span>
        @endif
    </div>
</div>

<div class="form-group {{ $errors->has('week_hours') ?  'has-error' : ''}}">
    {{ Form::label('week_hours', 'Рабочие часы', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-9">
        {{ Form::number('week_hours', null, ['class'=>'form-control']) }}
        @if ($errors->has('week_hours'))
            <span class="help-block">{{  $errors->first('week_hours') }}</span>
        @endif
    </div>
</div>

<div class="form-group">
    {{ Form::label('password', 'Пароль', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-9">
        <input type="password" name="password" class="form-control">
    </div>
</div>

<div class="form-group">
    <div class="col-md-9">
        @if ($formType == 'edit')
            {{ Form::submit('Сохранить', ['class' => 'btn btn-success btn-raised']) }}
        @else
            {{ Form::submit('Добавить', ['class' => 'btn btn-success btn-raised']) }}
        @endif
    </div>
</div>
{{ Form::close() }}



@if ($formType == 'edit')
    {!! Form::open(array('route' => ['user.destroy', 'id' => $user->id], 'method' => 'DELETE', 'class' => '')) !!}
        <div class="form-group">
            <div class="col-md-9">
        <button type="submit" class="btn btn-danger">Удалить</button>
            </div>
        </div>
    {!! Form::close() !!}
@endif
