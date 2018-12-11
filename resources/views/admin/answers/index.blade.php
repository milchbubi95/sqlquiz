@extends('layouts.admin')

@section('content')

    <?php
        use App\Test;
        use App\Question;
        use App\Answer;
        use Illuminate\Support\Facades\Auth;
        $users = Auth::user()->get();
        //$questions = Question::where('test_id', $test->id)->get();
    ?>

    <div class="container">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
            <a class="nav-link active" id="pills-test-tab" data-toggle="pill" href="#pills-test" role="tab" aria-controls="pills-test" aria-selected="true">Tests</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" id="pills-student-tab" data-toggle="pill" href="#pills-student" role="tab" aria-controls="pills-student" aria-selected="false">Studenten</a>
            </li>
        </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-test" role="tabpanel" aria-labelledby="pills-test-tab">
                    @foreach ($tests as $test)
                        <div class="row">    
                            {{$test->title}}
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="pills-student" role="tabpanel" aria-labelledby="pills-student-tab">
                    @foreach ($users as $user)
                        <div class="row">    
                            {{$user->name}}
                        </div>
                    @endforeach
                </div>
            </div>
    </div>

@endsection