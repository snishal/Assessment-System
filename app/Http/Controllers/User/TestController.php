<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function view(){
        $activeTests = Test::where('active', 1)->withCount('mcqs')->get();

        return view('user.home', [
            'tests' => $activeTests,
        ]);
    }
}
