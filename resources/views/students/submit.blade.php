@extends('layouts.app')

<?php
    use Illuminate\Support\Facades\Auth;
    use App\Answer;
    $user = Auth::user();
    $index = 0;
?>

@section('content')
    <div class="container">
        <div class="row">
            <h3>Erfolgreich abgegeben!</h3>
        </div>
    
    
    @foreach ($questions as $question)
        <?php
            $answer = Answer::where('question_id', $question->id)->where('user_id', $user->id)->first();
            $amount = $answer->result * 100;
            $index++;
        ?>
        <div style="margin-top: 30px; margin-bottom: 30px">
            <h5>Frage {{$index}}: {{$question->title}}</h5>
            <div class="progress">
                <div class="progress-bar w-{{$amount}}" role="progressbar" aria-valuenow="{{$amount}}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    @endforeach
    </div>

@endsection