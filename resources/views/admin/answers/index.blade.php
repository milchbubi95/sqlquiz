@extends('layouts.admin')

@section('content')

    <?php
        use App\Test;
        use App\Question;
        use App\Answer;
        use Illuminate\Support\Facades\Auth;
        $users = Auth::user()->get();
        $index = 0;
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
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">Nr.</th>
                                <th scope="col">Titel</th>
                                <th scope="col">Fragen</th>
                                <th scope="col">Abgaben</th>
                                </tr>
                            </thead>
                            <tbody>
                        @foreach ($tests as $test)
                            <?php 
                                $index++; 
                                $questions = Question::where('test_id', $test->id)->get();
                                $question = Question::where('test_id', $test->id)->first();
                                $countQ = count($questions);
                                $answers = Answer::where('question_id', $question['id'])->get();
                                $countA = count($answers);
                            ?>
                              <tr>
                                <th scope="row">{{$index}}</th>
                                <td><a href="answers/{{$test->id}}">{{$test->title}}</a></td>
                                <td>{{$countQ}}</td>
                                <td>{{$countA}}</td>
                              </tr>
                        @endforeach
                            </tbody>
                          </table>
                </div>
                <div class="tab-pane fade" id="pills-student" role="tabpanel" aria-labelledby="pills-student-tab">
                    <input type="text" class="form-control" id="searchInput" onkeyup="searchUser()" placeholder="Nach Namen suchen..." style="width: 100%">
                        <ul id="userList" style="margin-top: 10px">
                    @foreach ($users as $user)
                        @if ($user->roles->first()->name == 'student')
                            <li><a href="answers/evaluate/{{$user->id}}">{{$user->name}}</a></li>
                        @endif
                    @endforeach
                        </ul>
                </div>
            </div>
    </div>

@endsection