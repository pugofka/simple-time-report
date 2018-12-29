@if (isset($report))
    {{ Form::model($report, ['route' => ['reports.update', $report->id], 'method' => 'put']) }}
@else
    {!! Form::open(['url' => route('reports.store'), 'class'=>'form', 'method' => 'post']) !!}
@endif


@if ($formType == 'edit')
    <div class="form-group {{ $errors->has('plane_hours') ?  'has-error' : ''}}">
        {{ Form::label('plane_hours', 'Плановое рабочее время', ['class' => 'col-md-3 control-label']) }}
        <div class="col-md-9">
            {{ Form::number('plane_hours', null, ['class'=>'form-control', 'readonly'=>'readonly']) }}
            @if ($errors->has('plane_hours'))
                <span class="help-block">{{  $errors->first('plane_hours') }}</span>
            @endif
        </div>
    </div>
@endif

<div class="form-group {{ $errors->has('fact_hours') ?  'has-error' : ''}}">
    {{ Form::label('fact_hours', 'Фактическое рабочее время', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-9">
        {{ Form::number('fact_hours', null, ['class'=>'form-control', 'required']) }}
        @if ($errors->has('fact_hours'))
            <span class="help-block">{{  $errors->first('fact_hours') }}</span>
        @endif
    </div>
</div>

<div class="form-group {{ $errors->has('week_hours') ?  'has-error' : ''}}">
    {{ Form::label('week_hours', 'Рабочие часы', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-9">
        {{ Form::number('week_hours', null, ['class'=>'form-control', 'required']) }}
        @if ($errors->has('week_hours'))
            <span class="help-block">{{  $errors->first('week_hours') }}</span>
        @endif
    </div>
</div>

<div class="form-group {{ $errors->has('effective_hours') ?  'has-error' : ''}}">
    {{ Form::label('effective_hours', 'Эффективные рабочие часы', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-9">
        {{ Form::number('effective_hours', null, ['class'=>'form-control', 'required']) }}
        @if ($errors->has('effective_hours'))
            <span class="help-block">{{  $errors->first('effective_hours') }}</span>
        @endif
    </div>
</div>



<div class="form-group">
    <div class="col-md-9">
        @if ($formType == 'edit')
            {{ Form::submit('Сохранить', ['class' => 'btn btn-success btn-raised']) }}
        @else
            {{ Form::submit('Создать', ['class' => 'btn btn-success btn-raised']) }}
        @endif
    </div>
</div>
{{ Form::close() }}



@if ($formType == 'edit')
    {!! Form::open(array('route' => ['reports.destroy', 'id' => $report->id], 'method' => 'DELETE', 'class' => '')) !!}
    <div class="form-group">
        <div class="col-md-9">
            {{ Form::submit('Удалить', ['class' => 'btn btn-danger']) }}
        </div>
    </div>
    {!! Form::close() !!}
@endif
