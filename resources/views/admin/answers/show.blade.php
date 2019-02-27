@extends('layouts.admin')

@section('content')
    <?php
    use App\Answer;
    $index = 0;
    ?>

    <div class="container">
        <h3>{{$test->title}}</h3>
        @foreach ($questions as $question)
            <div style="margin-top: 30px; margin-bottom: 30px">
                <?php $index++; ?>   
            <h5>Frage {{$index}}: {{$question->text}}</h5>
        <?php
            $answers = Answer::where('question_id', $question->id)->get();
            $count = count($answers);
            $result = 0;
            foreach ($answers as $answer) {
                $result = $result + $answer->result;
            }
            if ($count != 0) {
                $result = $result / $count;
                $amount = $result * 100;
            } else {
                $amount = 0;
            }
        ?>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="{{$amount}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$amount}}%">{{$amount}}%</div>
            </div>
            <div style="text-align: right">
                    Abgaben: {{$count}}
            </div>
        </div>
    <hr>

        @endforeach
    </div>

@endsection