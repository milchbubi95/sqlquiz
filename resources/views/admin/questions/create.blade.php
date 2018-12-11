@extends('layouts.admin')

@section('content')

<div class="container">
        <div class="row">
            <h3>Frage erstellen</h3>
        </div>
        {!! Form::open(['action' => 'QuestionsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                <label for="questionTitle">Titel*</label>
                <input name="title" type="text" class="form-control" id="questionTitle" placeholder="Titel">
            </div>
            <div class="form-group">
                <label for="questionText">Fragestellung*</label>
                <textarea name="text" rows="3" class="form-control" id="questionText" placeholder="Frage"></textarea>
            </div>
            <div class="form-group">
                <label for="questionSolution">Lösung*</label>
                <textarea name="solution" rows="3" class="form-control" id="questionSolution" placeholder="Lösung"></textarea>
            </div>
            <div class="form-group">
                <label for="questionDifficult">Schwierigkeitsgrad*</label>
                <input name="difficulty" type="number" class="form-control" id="questionDifficult" placeholder="0-5">
            </div>
            <div class="form-group">
                <label for="questionTest">Test*</label>
                <select name="test_id" class="form-control" id="questionTest">
                    @foreach ($tests as $test)
                    <option value="{{$test->id}}">{{$test->title}}</option>
                    @endforeach
                  </select>
            </div>
            <div class="form-group">
                <label for="questionImg">Bild*</label>
                <input name="img" type="file" class="form-control" id="questionImg">
            </div>
            {{Form::submit('Senden', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>

@endsection