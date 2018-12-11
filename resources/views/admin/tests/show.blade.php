@extends('layouts.admin')

@section('content')

<?php
use App\Question;
$questions = Question::where('test_id', $test->id)->get();
?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <h1>{{$test->title}}</h1>
        </div>
        <div class="col-6" style="text-align: right">
            <a class="btn btn-success" href="../questions/create" role="button">Frage hinzufügen</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p>{{$test->description}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h3>Fragen</h3>
            
            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Titel</th>
                    <th scope="col">Schwierigkeit</th>
                    <th scope="col">Lösung</th>
                    <th scope="col">Erstellt am</th>
                </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    @foreach($questions as $question)
                    <tr>
                        <th scope="row">{{$count}}</th>
                        <td><a href="questions/{{$question->id}}">{{$question->title}}</a></td>
                        <td>{{$question->difficulty}}</td>
                        <td>{{$question->solution}}</td>
                        <td>{{$question->created_at}}</td>
                    </tr>
                    <?php $count++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection