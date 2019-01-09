@extends('layouts.admin')

@section('content')
<?php
    use App\Question;
    use Illuminate\Support\Facades\Auth;
    use App\Answer;
    use App\User;

    $user = Auth::user();
    $users = User::all();
?>

    <div class="container">
        <div class="row">
            <h3>{{$user->name}}</h3>
        </div>
    
        <div class="row">
            <div class="col-12">
                <h5>Rechte verwalten</h5>
                <input type="text" class="form-control" id="searchInput" onkeyup="searchUser()" placeholder="Nach Namen suchen..." style="width: 100%">
                <ul id="userList" style="margin-top: 10px">
                    @foreach ($users as $user)
                        <li><a href="rights/{{$user->id}}">{{$user->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

</div>

@endsection