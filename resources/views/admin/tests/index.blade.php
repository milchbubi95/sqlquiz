@extends('layouts.admin')

@section('content')
<?php
use App\Question;
use App\User;
?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <h1>Tests</h1>
        </div>
        <div class="col-6" style="text-align: right">
            <a class="btn btn-success" href="tests/create" role="button">Test hinzufügen</a>
        </div>
    </div>
    @if(count($tests) > 0)
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col"></th>
            <th scope="col">Titel</th>
            <th scope="col">Fragen</th>
            <th scope="col">Erstellt von</th>
            <th scope="col">Erstellt am</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            @foreach($tests as $test)
            <tr>
                <th scope="row">{{$count}}</th>
                <td><a href="tests/{{$test->id}}">{{$test->title}}</a></td>
                <td>{{Question::where('test_id', $test->id)->count()}}</td>
                <?php $user = User::where('id', $test->user_id)->first(); ?>
                <td>{{$user->name}}</td>
                <td>{{$test->created_at}}</td>
                <td>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                    <button class="btn btn-primary"><a href="tests/{{$test->id}}/edit" style="color: white"><i class="fas fa-pen"></i></a></button>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6" style="margin-left: 5px">
                    {!!Form::open(['action' => ['TestsController@destroy', $test->id], 'method' => 'POST'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            <button type="submit" class="btn btn-primary"><i class="fas fa-trash"></i></button>
                        {!!Form::close()!!}
                    </div>
                </div>
                </div>
            </tr>
            <?php $count++; ?>
            @endforeach
        </tbody>
    </table>
</div>

    <div class="container">
        {{ $tests->links() }}
    </div>

@else 
<h5>Keine Tests vorhanden!</h5>
@endif

@endsection