<?php

namespace App\Http\Controllers;

use App\Test;
use App\Question;
use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use \PHPSQLParser\PHPSQLParser;
use \Rogervila\ArrayDiffMultidimensional;

class StudentsController extends Controller
{
    /**
     * Display a listing of the tests applicable to the students.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // If user is logged in
        if($user = Auth::user()) {
            // Get all tests ordered by the created date with a pagination of ten
            $tests = Test::orderBy('created_at','asc')->paginate(10);
            // Check for permissions
            $request->user()->authorizeRoles(['student', 'dozent']);
            return view('students.index')->with('tests', $tests);
        } else {
            return view('auth.login');
        }
    }

    /**
     * Show the form for creating a new student.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified test the student selected.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @param  \App\Test  $test
     */
    public function show($id)
    {
        // Get the specified test
        $test = Test::find($id);
        return view('students.show')->with('test', $test);
    }

    /**
     * Show the form for editing the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified test with the students answers in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get the specified questions belonging to the current test
        $questions = Question::where('test_id', $id)->get();

        // Loop trough all questions
        foreach ($questions as $question) {
            //Create a new answer for every question with its solution formatted uppercase
            $answer = new Answer;
            $solution = Question::where('id', $question->id)->first();
            $solutionText = $solution->solution;

            //Get the answer given by the student formatted uppercase
            $answerText = $request->input('solution'.$question->id);
            

            //Get an array with every single SQL statement from the solution and answer
            //through the PHPSQLParser library (https://github.com/greenlion/PHP-SQL-Parser)
            $Qparser = new PHPSQLParser();
            $Qparsed = $Qparser->parse($solutionText);
            if ($answerText != null) {
                $Aparser = new PHPSQLParser();
                $Aparsed = $Aparser->parse($answerText);
            } else {
                $Aparsed = 0;
            }

            //If students answer is not empty
            if ($Aparsed != 0) {
                //Count how many statements where found in the students answer
                $counter = count($Aparsed);
                //Compare the right solution with the answer given by the student with a library
                //which compares multidimensional arrays
                $diff = ArrayDiffMultidimensional::compare($Aparsed, $Qparsed);
            } else {
                //If students answer is empty
                $counter = 0;
            }
            
            //Evalutate how many mistakes where made
            //If answer array is not empty
            if ($counter != 0) {
                //If differences from the comparison between solution and answer where found
                if ($diff != 0) {
                    //Start with 100% correct
                    $result = 1;
                    //Remove percentages for every difference or mistakes
                    //depending on the size of the answer array
                    $result = $result - (count($diff) / $counter);
                    $result = round($result, 2);
                } else {
                    //If no differences where found, answer and solution are the same
                    $result = 1;
                }
            } else {
                //If answer array is empty, student didnt gave any input
                $result = 0;
            }
            
            //Save the answer with the answer given by the student
            $answer->text = $answerText;
            $answer->result = $result;
            $answer->user_id = Auth::id();
            $answer->question_id = $question->id;
            $answer->save();
        }

        return view('students/submit')->with('questions', $questions);
    }

    /**
     * Remove the specified student from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

