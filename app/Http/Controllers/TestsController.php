<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class TestsController extends Controller
{
    /**
     * Display a listing of the tests.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // If user is logged in
        if($user = Auth::user()) {
            $tests = Test::orderBy('created_at','asc')->paginate(10);
            // Check for permissions
            $request->user()->authorizeRoles(['dozent']);
            return view('admin.tests.index')->with('tests', $tests);
        } else {
            return view('auth.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Check for permissions
        $request->user()->authorizeRoles(['dozent']);
        return view('admin.tests.create');
    }

    /**
     * Store a newly created test in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the new test with certain fields
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        // Create a new test
        $test = new Test;
        // Get every field from the new test
        $test->title = $request->input('title');
        $test->description = $request->input('description');
        $test->user_id = Auth::id();
        // Save the test
        $test->save();

        // Check for permissions
        $request->user()->authorizeRoles(['dozent']);
        return redirect('admin/tests')->with('success', 'Test erfolgreich erstellt!');
    }

    /**
     * Display the specified test.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        // Get the specified test.
        $test = Test::find($test->id);
        return view('admin.tests.show')->with('test', $test);
    }

    /**
     * Show the form for editing the specified test.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified test in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified test from storage.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}
