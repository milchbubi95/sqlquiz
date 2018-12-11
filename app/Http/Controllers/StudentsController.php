<?php

namespace App\Http\Controllers;

use App\Test;
use App\Question;
use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($user = Auth::user()) {
            $tests = Test::orderBy('created_at','asc')->paginate(10);
            $request->user()->authorizeRoles(['student', 'dozent']);
            return view('students.index')->with('tests', $tests);
        } else {
            return view('auth.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @param  \App\Test  $test
     */
    public function show($id)
    {
        $test = Test::find($id);
        return view('students.show')->with('test', $test);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $questions = Question::where('test_id', $id)->get();

        foreach ($questions as $question) {
            $answer = new Answer;
            $answerText = $request->input('solution'.$question->id);
            $solution = Question::where('id', $question->id)->first();
            if ($answerText == $solution->solution) {
                $answer->result = 1;
            } else {
                $answer->result = 0;
            }
            $answer->text = $request->input('solution'.$question->id);
            $answer->user_id = Auth::id();
            $answer->question_id = $question->id;
            $answer->save();
        }

        return view('students/submit')->with('questions', $questions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
