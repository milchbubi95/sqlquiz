<?php

namespace App\Http\Controllers;

use App\Question;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($user = Auth::user()) {
            $questions = Question::orderBy('created_at','asc')->paginate(10);
            $request->user()->authorizeRoles(['dozent']);
            return view('admin.questions.index')->with('questions', $questions);
        } else {
            return view('auth.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Test  $test
     */
    public function create(Request $request)
    {   
        $tests = Test::get();
        $request->user()->authorizeRoles(['dozent']);
        return view('admin.questions.create')->with('tests', $tests);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required',
            'solution' => 'required',
            'difficulty' => 'required',
            'test_id' => 'required',
        ]);

        // Handle File Upload
        if($request->hasFile('img')){
            // Get filename with the extension
            $filenameWithExt = $request->file('img')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('img')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('img')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Question
        $question = new Question;
        $question->title = $request->input('title');
        $question->text = $request->input('text');
        $question->solution = $request->input('solution');
        $question->difficulty = $request->input('difficulty');
        if($request->hasFile('img')){
            $question->img = $fileNameToStore;
        }
        $question->test_id = $request->input('test_id');
        $question->save();

        $request->user()->authorizeRoles(['dozent']);
        return redirect('admin/questions')->with('success', 'Frage erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question = Question::find($question->id);
        return view('admin/questions.show')->with('question', $question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $question = Question::find($question->id);

        return view('admin/questions.edit')->with('question', $question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required',
            'solution' => 'required',
            'difficulty' => 'required',
            'test_id' => 'required',
        ]);

        // Handle File Upload
        if($request->hasFile('img')){
            // Get filename with the extension
            $filenameWithExt = $request->file('img')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('img')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('img')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Update Question
        $question = Question::find($question->id);
        $question->title = $request->input('title');
        $question->text = $request->input('text');
        $question->solution = $request->input('solution');
        $question->difficulty = $request->input('difficulty');
        if($request->hasFile('img')){
            $question->img = $fileNameToStore;
        }
        $question->test_id = $request->input('test_id');
        $question->save();

        $request->user()->authorizeRoles(['dozent']);
        return redirect('admin/questions')->with('success', 'Frage erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);

        if($question->img != 'noimage.jpg'){
            // Delete Question
            Storage::delete('public/images/'.$question->img);
        }
        
        $question->delete();
        return redirect('admin/questions')->with('success', 'Frage gelöscht');
    }
}
