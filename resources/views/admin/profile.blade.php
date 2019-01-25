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
            <div class="col-12">
                <h5>Rechte verwalten</h5>
                <input type="text" class="form-control" id="searchInput" onkeyup="tableSearch()" placeholder="Nach Namen suchen..." style="width: 100%">
                <table id="userTable" style="margin-top: 30px" class="table">
                    <tr>
                        <th>Name</th>
                        <th>Rolle</th>
                        <th>Rolle wechseln</th>
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->roles->first()->name}}</td>
                            <td>
                                    @if ($user->roles->first()->name == 'dozent')
                                        <a href="take/{{$user->id}}">Rechte nehmen</a>
                                    @else
                                        <a href="give/{{$user->id}}">Rechte geben</a>
                                    @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

</div>

@endsection