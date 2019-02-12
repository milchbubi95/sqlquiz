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
     * Display a listing of the questions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // If user is logged in
        if($user = Auth::user()) {
            $questions = Question::orderBy('created_at','asc')->paginate(10);
            // Check for permissions
            $request->user()->authorizeRoles(['dozent']);
            return view('admin.questions.index')->with('questions', $questions);
        } else {
            return view('auth.login');
        }
    }

    /**
     * Show the form for creating a new question.
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Test  $test
     */
    public function create(Request $request)
    {   
        // Get all tests
        $tests = Test::get();
        // Check for permissions
        $request->user()->authorizeRoles(['dozent']);
        return view('admin.questions.create')->with('tests', $tests);
    }

    /**
     * Store a newly created question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the new question with certain fields
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
            // Get just extension
            $extension = $request->file('img')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('img')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create a new question
        $question = new Question;
        // Get every field from the new question
        $question->title = $request->input('title');
        $question->text = $request->input('text');
        $question->solution = $request->input('solution');
        $question->difficulty = $request->input('difficulty');
        // If image is attached, then handle file upload
        if($request->hasFile('img')){
            $question->img = $fileNameToStore;
        }
        // Set reference to test
        $question->test_id = $request->input('test_id');
        // Save new question
        $question->save();

        // Check for permissions
        $request->user()->authorizeRoles(['dozent']);
        return redirect('admin/questions')->with('success', 'Frage erfolgreich erstellt!');
    }

    /**
     * Display the specified question.
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
     * Show the form for editing the specified question.
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
     * Update the specified question in storage.
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
            // Get just extension
            $extension = $request->file('img')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('img')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Update the specified question
        $question = Question::find($question->id);
        // Get every field from the new question
        $question->title = $request->input('title');
        $question->text = $request->input('text');
        $question->solution = $request->input('solution');
        $question->difficulty = $request->input('difficulty');
        // If image is attached, then handle file upload
        if($request->hasFile('img')){
            $question->img = $fileNameToStore;
        }
         // Set reference to test
        $question->test_id = $request->input('test_id');
         // Update the question
        $question->save();

        // Check for permissions
        $request->user()->authorizeRoles(['dozent']);
        return redirect('admin/questions')->with('success', 'Frage erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified question from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);

        if($question->img != 'noimage.jpg'){
            // Delete the specified question
            Storage::delete('public/images/'.$question->img);
        }
        
        $question->delete();
        return redirect('admin/questions')->with('success', 'Frage gelöscht');
    }
}
