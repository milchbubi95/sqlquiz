@extends('layouts.app')

<?php
    use Illuminate\Support\Facades\Auth;
    use App\Answer;
    $user = Auth::user();
?>

@section('content')
    <div class="container">
        <div class="row">
            <h3>Erfolgreich abgegeben!</h3>
        </div>
    </div>
    
    @foreach ($questions as $question)
        <?php
            $answer = Answer::where('question_id', $question->id)->where('user_id', $user->id)->first();
        ?>
        {{$answer->result}}
    @endforeach

@endsection