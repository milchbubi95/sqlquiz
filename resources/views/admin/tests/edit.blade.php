@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <h3>Test bearbeiten</h3>
        </div>
        {!! Form::open(['action' => ['TestsController@update', $test->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="form-group">
                <label for="testsTitle">Titel*</label>
                <input name="title" type="text" class="form-control" id="testsTitle" placeholder="Titel" value="{{$test->title}}">
            </div>
            <div class="form-group">
                <label for="testsDescription">Beschreibung*</label>
                <textarea name="description" rows="3" class="form-control" id="testsDescription" placeholder="Beschreibung">{{$test->description}}</textarea>
            </div>
            {{Form::submit('Senden', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>

@endsection