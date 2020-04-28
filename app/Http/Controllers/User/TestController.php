<?php

namespace App\Http\Controllers\User;

use App\CodingQuestion;
use App\Http\Controllers\Controller;
use App\MultipleChoiceQuestion;
use App\Test;
use App\TestResponse;
use Carbon\Carbon;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\Json;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class TestController extends Controller
{
    public function view(){
        $activeTests = Test::where('active', 1)->withCount('mcqs')->withCount('cqs')->get();
        $testResponses = TestResponse::where('user_id', Auth::user()->id)->get();

        return view('user.home', [
            'tests' => $activeTests,
            'testResponses' => $testResponses
        ]);
    }

    public function takeTest(Test $test){
        $id = TestResponse::create([
            'test_id' => $test->id,
            'user_id' => auth()->user()->id,
            'start_time' => now(),
        ])->id;
        // $id = $test->responses()->attach(auth()->user()->id, [
        //     'start_time' => now(),
        // ])->id;
        return redirect()->route('user.test', [
                'testresponse' => $id,
            ]);
    }

    public function test(TestResponse $testresponse){
        $test = Test::where('id', $testresponse->test_id)->first();
        $mcqs = $test->mcqs()->select('mcq_id', 'text', 'media_path', 'option1', 'option2', 'option3', 'option4')->get();
        $cqs = $test->cqs()->select('cq_id', 'name', 'description', 'question_index')->get();

        $chapterWiseProblems = json_decode(Storage::get('problem_mapping.json'));

        foreach ($cqs as $cq) {
            $index = explode(',', $cq->question_index);
            $problem = $chapterWiseProblems[$index[0]]->problems[$index[1]];

            $cq->cpp_filename = "EPIJudge/" . $problem->cpp->filename;
            $cq->cpp = Storage::get($cq->cpp_filename);

            $cq->java_filename = "EPIJudge/" . $problem->java->filename;
            $cq->java= Storage::get($cq->java_filename);

            $cq->python_filename = "EPIJudge/" . $problem->python->filename;
            $cq->python = Storage::get($cq->python_filename);

            $cq->total = $problem->cpp->total;
            $cq->passed = 0;
        }

        $start_time = Carbon::parse($testresponse->start_time);
        $duration = Carbon::parse($test->duration)->secondsSinceMidnight();
        $limit = $start_time->addSeconds($duration);

        $time_left = $limit->diffInSeconds(now());

        return view('user.test', [
            'cqs' => $cqs,
            'mcqs' => $mcqs,
            'test_response_id' => $testresponse->id,
            'time_left' => Carbon::parse($time_left),
        ]);
        if($time_left > 0){
            return view('user.test', [
                'cqs' => $cqs,
                'mcqs' => $mcqs,
                'test_response_id' => $testresponse->id,
                'time_left' => Carbon::parse($time_left),
            ]);
        }else{
            return redirect('/users');
        }
    }

    public function finishTest(Request $request, TestResponse $testresponse){
        $end_time = now();
        $time_taken = $end_time->diffInSeconds($testresponse->start_time);
        $test = Test::find($testresponse->test_id);

        // $duration = Carbon::parse($test->duration)->secondsSinceMidnight();

        $codingWeight = $test->codingWeight;
        $mcqWeight = $test->mcqWeight;
        $totalScore = 0;

        $mcqResponses = json_decode($request['mcqResponses']);

        foreach($mcqResponses as $response){
            $mcq = MultipleChoiceQuestion::find($response->id);
            if($mcq->correct_option == $response->responseVal){
                $totalScore += $mcqWeight;
            }
        }

        $cqResponses = json_decode($request['cqResponses']);
        foreach($cqResponses as $response){
            $totalScore += ($response->passed/$response->total) * $codingWeight;
        }

        $testresponse->score = $totalScore;
        $testresponse->end_time = $end_time;
        $testresponse->save();

        return redirect('/user');
    }

    public function runCode(Request $request){
        Storage::move($request["filename"], $request["filename"] . ".copy");
        Storage::disk('local')->put($request["filename"], $request["code"]);

        $result = shell_exec("cd ../storage/app/EPIJudge/epi_judge_cpp && make last 2>&1");

        Storage::delete($request["filename"]);
        Storage::move($request["filename"] . ".copy", $request["filename"]);

        $problem_mapping = Storage::get("EPIJudge/problem_mapping.js");
        $problem_mapping = str_replace("problem_mapping = ", "", $problem_mapping);
        $problem_mapping = str_replace(";", "", $problem_mapping);
        $problem_mapping = json_decode($problem_mapping);

        $language_solution = $request["lang"] . ": " . explode("/", $request["filename"])[2];

        foreach ($problem_mapping as $chapters) {
            foreach ($chapters as $problem) {
                foreach ($problem as $key => $language_solution_mapping) {
                    if($key == $language_solution){
                        return [
                            "result" => $result,
                            "passed" => $language_solution_mapping->passed,
                        ];
                    }
                }
            }
        }
    }
}
