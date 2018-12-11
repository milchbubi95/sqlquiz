@extends('layouts.admin')

@section('content')

<?php
    use App\Test;
    use App\Question;

    $test = Test::count();
    $question = Question::count();
?>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="jumbotron">
                    <h1><i class="fas fa-file-alt"></i></h1>
                    <h2>{{$test}} Tests</h2>
                    <hr class="my-4">
                    <a class="btn btn-secondary" href="tests" role="button">Zu den Tests</a>
                </div>
        </div>
            <div class="col-md-6 col-sm-12">
                <div class="jumbotron">
                    <h1><i class="fas fa-question-circle"></i></h1>
                    <h2>{{$question}} Fragen</h2>
                    <hr class="my-4">
                    <a class="btn btn-secondary" href="questions" role="button">Zu den Fragen</a>
                </div>
            </div>
        </div>
    </div>

@endsection