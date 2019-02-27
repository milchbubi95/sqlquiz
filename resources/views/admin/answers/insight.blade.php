@extends('layouts.admin')

@section('content')

<?php
    use \Qazd\TextDiff;
    use App\User;
    $i = 0;
?>

    <div class="container">
        <div class="row">
            @foreach ($answers as $answer)
                <?php
                    $user = User::where('id', $answer->user_id)->first(); 
                    $table = TextDiff::render($answer->text, $question->solution);
                ?>
                @if ($table != null)
                    <h5>Abgabe von {{$user->name}}</h5>
                    <?= $table ?>
                    <hr>
                @else
                    <?php $i++; ?>
                @endif
            @endforeach
        </div>
        <hr>
        <div class="row">
            <h3>Richtige Abgaben: {{$i}}</h3>
        </div>
    </div>

@endsection