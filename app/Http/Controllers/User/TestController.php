<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Test;
use App\TestResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function view(){
        $activeTests = Test::where('active', 1)->withCount('mcqs')->get();

        return view('user.home', [
            'tests' => $activeTests,
        ]);
    }

    public function takeTest(Test $test){
        // TestResponse::create([
        //     'test_id' => $test->id,
        //     'user_id' => auth()->user()->id,
        //     'start_time' => now(),
        // ]);
        return view('user.test', [
            'test' => $test,
        ]);
    }
}
