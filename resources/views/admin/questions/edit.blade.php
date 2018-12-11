@extends('layouts.admin')

@section('content')

<?php 
    use App\Test;
    $tests = Test::get();
?>

<div class="container">
        <div class="row">
            <h3>Frage erstellen</h3>
        </div>
        {!! Form::open(['action' => ['QuestionsController@update', $question->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
            <div class="form-group">
                <label for="questionTitle">Titel*</label>
                <input name="title" type="text" class="form-control" id="questionTitle" placeholder="{{$question->title}}">
            </div>
            <div class="form-group">
                <label for="questionText">Fragestellung*</label>
                <textarea name="text" rows="3" class="form-control" id="questionText" placeholder="{{$question->text}}"></textarea>
            </div>
            <div class="form-group">
                <label for="questionSolution">Lösung*</label>
                <textarea name="solution" rows="3" class="form-control" id="questionSolution" placeholder="{{$question->solution}}"></textarea>
            </div>
            <div class="form-group">
                <label for="questionDifficult">Schwierigkeitsgrad*</label>
                <input name="difficulty" type="number" class="form-control" id="questionDifficult" placeholder="{{$question->difficulty}}">
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
                <label for="questionImg">Bild</label>
                <input name="img" type="file" class="form-control" id="questionImg">
            </div>
            {{Form::submit('Senden', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>

@endsection