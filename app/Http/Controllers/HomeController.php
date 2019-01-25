<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use App\Test;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['student', 'dozent']);

        if($user = Auth::user()) {
            $tests = Test::orderBy('created_at','asc')->paginate(10);
            $request->user()->authorizeRoles(['student', 'dozent']);
            return view('students.index')->with('tests', $tests);
        } else {
            return view('auth.login');
        }
    
    }

    public function admin(Request $request) {
        $request->user()->authorizeRoles(['dozent']);
            return view('admin.home');
    }

    public function profile(Request $request) {
        $request->user()->authorizeRoles(['dozent']);
            return view('admin.profile');
    }

    public function giveRights(Request $request, $id) {
        $request->user()->authorizeRoles(['dozent']);
        $user = User::find($id);
        $user->roles()->sync(2);
        return redirect('admin/profile')->with('success', $user->name . ' hat Rechte erhalten.');
    }

    public function takeRights(Request $request, $id) {
        $request->user()->authorizeRoles(['dozent']);
        $user = User::find($id);
        $user->roles()->sync(1);
        return redirect('admin/profile')->with('success', $user->name . ' wurden Rechte genommen.');
    }
}
