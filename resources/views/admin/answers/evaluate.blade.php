@extends('layouts.admin')

@section('content')
    <?php
    use App\Question;
    use App\Test;
    $index = 0;
    $new = '';
    ?>

    <div class="container">
        <h3>{{$user->name}}</h3>
        @if (count($answers) > 0)
        @foreach ($answers as $answer)
            <?php 
                $question = Question::where('id', $answer->question_id)->first();
                $test = Test::where('id', $question->test_id)->first();
                $old = $test->title;
                $amount = $answer->result * 100;
            ?>
        @if ($old != $new)
            <h5 style="margin-top: 50px">{{$test->title}}</h5>
        @endif
            {{$question->text}}
            <div class="progress">
                <div class="progress-bar w-{{$amount}}" role="progressbar" aria-valuenow="{{$amount}}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <?php $new = $test->title; ?>
        @endforeach
        
        @else
            <h5>Keine Abgaben vorhanden!</h5>
        @endif
    </div>

@endsection