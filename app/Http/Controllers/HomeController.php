<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

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
            return view('home');
    
    }

    public function admin(Request $request) {
        $request->user()->authorizeRoles(['dozent']);
            return view('admin.home');
    }

    public function profile(Request $request) {
        $request->user()->authorizeRoles(['dozent']);
            return view('admin.profile');
    }

    public function rights(Request $request, $id) {
        $request->user()->authorizeRoles(['dozent']);
        $user = User::find($id);
        $user->roles()->sync(2);
        return redirect('admin/profile')->with('success', $user->name . ' hat Rechte erhalten.');
    }
}
