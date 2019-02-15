@extends('layouts.app')

@section('content')
    <?php
    use App\Question;
    use Illuminate\Support\Facades\Auth;
    use App\Answer;

    $user = Auth::user();

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
        <?php
            $firstQuestion = Question::where('test_id', $test->id)->first();
            $check = Answer::where('question_id', $firstQuestion["id"])->where('user_id', $user["id"])->first();

            if ($check != null) {
                $done = 1;
            } else {
                $done = 0;
            }
        ?>
    <div class="col-md-6 col-sm-12">
        <div class="jumbotron">
            <h2>{{$test->title}}</h2>
                <p class="lead">{{$test->description}}</p>
            <hr>
            <div class="row">
            <div class="col-6">
                <p class="lead">{{Question::where('test_id', $test->id)->count()}} Fragen</p>
            </div>
            @if ($done == 0)
            <div class="col-6" style="text-align: right">
                <a class="btn btn-primary" href="students/{{$test->id}}" role="button">Test starten</a>
            </div>
            @else
            <div class="col-6" style="text-align: right">
                <i class="far fa-check-circle" style="font-size: 24pt; color: green"></i>
            </div>
            @endif
            </div>
        </div>
    </div>
    @endforeach

        @else 
        Keine Tests!
        @endif
    </div>
</div>

<div class="container">
    {{ $tests->links() }}
</div>

@endsection