@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>{{$question->title}}</h1>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <h3>Frage</h3>
                        <p>{{$question->text}}</p>
                    </div>
                    <div class="col-6">
                        <h3>Lösung</h3>
                        <p>{{$question->solution}}</p>
                    </div>
                </div>
                <hr>
                <div class="container">
                    <div class="row justify-content-between">
                        @if(!Auth::guest())
                            <button class="btn btn-primary">
                                <a href="../questions/{{$question->id}}/edit" style="color: white">Bearbeiten</a>
                            </button>
                
                            {!!Form::open(['action' => ['QuestionsController@destroy', $question->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Löschen', ['class' => 'btn btn-danger'])}}
                            {!!Form::close()!!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection