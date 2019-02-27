<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Test;
use App\Question;
use App\User;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    /**
     * Display a listing of the answers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tests = Test::all();
        $request->user()->authorizeRoles(['dozent']);
        return view('admin.answers.index')->with('tests', $tests);
    }

    /**
     * Show the form for creating a new answer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created answer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified answer.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $test = Test::where('id', $id)->first();
        $questions = Question::where('test_id', $test->id)->get();

        return view('admin.answers.show')->with(compact('test','questions'));
    }

    /**
     * Show the form for editing the specified answer.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function evaluate($id)
    {
        $user = User::where('id', $id)->first();
        $answers = Answer::where('user_id', $user->id)->get();

        return view('admin.answers.evaluate')->with(compact('user','answers'));
    }

    public function insight($id) {
        $question = Question::where('id', $id)->first();
        $answers = Answer::where('question_id', $question->id)->get();

        return view('admin.answers.insight')->with(compact('answers', 'question'));
    }

    /**
     * Update the specified answer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified answer from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
