@extends('layouts.app')

@section('content')
    <?php
    use App\Question;
    ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Test auswählen</h1>
        </div>
    </div>
    <div class="row">
    @if(count($tests) > 0)
    @foreach ($tests as $test)
    <div class="col-md-6 col-sm-12">
        <div class="jumbotron">
            <h2>{{$test->title}}</h2>
                <p class="lead">{{$test->description}}</p>
            <hr>
            <div class="row">
            <div class="col-6">
                <p class="lead">{{Question::where('test_id', $test->id)->count()}} Fragen</p>
            </div>
            <div class="col-6" style="text-align: right">
                <a class="btn btn-primary" href="students/{{$test->id}}" role="button">Test starten</a>
            </div>
            </div>
        </div>
    </div>
    @endforeach

        @else 
        Keine Tests!
        @endif
    </div>
</div>

@endsection