@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <h3>Test erstellen</h3>
        </div>
        {!! Form::open(['action' => 'TestsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        
            <div class="form-group">
                <label for="testsTitle">Titel*</label>
                <input name="title" type="text" class="form-control" id="testsTitle" placeholder="Titel">
            </div>
            <div class="form-group">
                <label for="testsDescription">Beschreibung*</label>
                <textarea name="description" rows="3" class="form-control" id="testsDescription" placeholder="Beschreibung"></textarea>
            </div>
            {{Form::submit('Senden', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>

@endsection