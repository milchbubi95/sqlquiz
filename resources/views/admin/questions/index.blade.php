@extends('layouts.admin')

@section('content')

<?php
use App\Test;
?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <h1>Fragen</h1>
        </div>
        <div class="col-6" style="text-align: right">
            <a class="btn btn-success" href="questions/create" role="button">Frage hinzufügen</a>
        </div>
    </div>
    @if(count($questions) > 0)
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col"></th>
            <th scope="col">Titel</th>
            <th scope="col">Fragenstellung</th>
            <th scope="col">Lösung</th>
            <th scope="col">Tools</th>
        </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            @foreach($questions as $question)
            <tr>
                <th scope="row">{{$count}}</th>
                <td><a href="questions/{{$question->id}}">{{$question->title}}</a></td>
                <?php $test = Test::where('id', $question->test_id)->get(); ?>
                <td>{{substr($question->text, 0, 30)}}</td>
                <td>{{substr($question->solution, 0, 30)}}</td>
                <td>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                        <button class="btn btn-primary"><a href="questions/{{$question->id}}/edit" style="color: white"><i class="fas fa-pen"></i></a></button>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                        {!!Form::open(['action' => ['QuestionsController@destroy', $question->id], 'method' => 'POST'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                <button type="submit" class="btn btn-primary"><i class="fas fa-trash"></i></button>
                            {!!Form::close()!!}
                        </div>
                    </div>
                </td>
            </tr>
            <?php $count++; ?>
            @endforeach
        </tbody>
    </table>
</div>

@else 
Keine Fragen!
@endif

@endsection