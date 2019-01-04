<?php

namespace App\Http\Controllers;

use App\Test;
use App\Question;
use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Lib\src\PHPSQLParser;

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
        //require_once('php-sql-parser/src/PHPSQLParser.php');

        $questions = Question::where('test_id', $id)->get();

        foreach ($questions as $question) {
            $answer = new Answer;
            $solution = Question::where('id', $question->id)->first();

            $answerText = $request->input('solution'.$question->id);

            $Qparser = new PHPSQLParser();
            $Qparsed = $Qparser->parse($solution->solution);
            $Aparser = new PHPSQLParser();
            $Aparsed = $Aparser->parse($answerText);
           
            $counter = count($Aparsed);

            $diff = array_diff_assoc_recursive($Qparsed, $Aparsed);
            
            if ($diff != 0) {
                $result = 1;
                $result = $result - (count($diff) / $counter);
                echo $result;
            } else {
                $result = 1;
            }
            
            $answer->text = $answerText;
            $answer->result = $result;
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

    public function array_diff_assoc_recursive($array1, $array2) {
	    foreach($array1 as $key => $value) {
            if(is_array($value)) {
                if(!isset($array2[$key])) {
                    $difference[$key] = $value;
                } elseif (!is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                    if($new_diff != FALSE) {
                        $difference[$key] = $new_diff;
                    }
                }
            } elseif(!isset($array2[$key]) || $array2[$key] != $value) {
                $difference[$key] = $value;
            }
        }
        return !isset($difference) ? 0 : $difference;
    }
}
