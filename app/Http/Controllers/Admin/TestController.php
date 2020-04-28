<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::all();
        return view('admin.tests.view',[
            'tests' => $tests,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $test = Test::create(request(['title', 'duration', 'mcqWeight', 'codingWeight']));

        if($request->filled('mcqs')){
            $test->mcqs()->attach($request['mcqs']);
        }

        if($request->filled('cqs')){
            $test->cqs()->attach($request['cqs']);
        }

        return redirect('/admin/tests');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        return $test;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        return view('admin.tests.edit', [
            'test' => $test,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        if($request->ajax()){
            $test['active'] = $request->filled('active') ? $request['active'] : $test['active'];
            $test->save();

            return "true";
        }

        $test['title'] = $request->filled('title') ? $request['title'] : $test['title'];
        $test['duration'] = $request->filled('duration') ? $request['duration'] : $test['duration'];
        $test['mcqWeight'] = $request->filled('mcqWeight') ? $request['mcqWeight'] : $test['mcqWeight'];
        $test['codingWeight'] = $request->filled('codingWeight') ? $request['codingWeight'] : $test['codingWeight'];

        if($request->filled('mcqs')){
            $test->mcqs()->attach(array_diff($request['mcqs'], $test->mcqs->pluck('id')->toArray()));
            $test->mcqs()->detach(array_diff($test->mcqs->pluck('id')->toArray(), $request['mcqs']));
        }else{
            $test->mcqs()->detach();
        }

        if($request->filled('cqs')){
            $test->cqs()->attach(array_diff($request['cqs'], $test->cqs->pluck('id')->toArray()));
            $test->cqs()->detach(array_diff($test->cqs->pluck('id')->toArray(), $request['cqs']));
        }else{
            $test->cqs()->detach();
        }

        $test->save();

        return redirect('/admin/tests');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        $test->delete();


        return redirect('/admin/tests');
    }
}
