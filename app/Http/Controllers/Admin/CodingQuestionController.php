<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\CodingQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CodingQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cqs = CodingQuestion::all();

        if($request->ajax()){

            $response = [];

            foreach($cqs as $cq){
                array_push($response, [
                    'name' => $cq->name,
                    'value' => $cq->id
                ]);
            }

            return [
                'success' => true,
                'results' => $response,
            ];
        }

        return view('admin.cqs.view', [
            'cqs' => $cqs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapterWiseProblems = Storage::get('problem_mapping.json');
        return view('admin.cqs.create', [
            'problems' => $chapterWiseProblems
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CodingQuestion::create(request(['name', 'question_index', 'description']));

        // return redirect()->back()->withErrors($validator)->withInput();
        return redirect('/admin/cqs');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CodingQuestion  $codingQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(CodingQuestion $cq)
    {
        return $cq;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CodingQuestion  $codingQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(CodingQuestion $cq)
    {
        return view('admin.cqs.edit', [
            'cq' => $cq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CodingQuestion  $codingQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CodingQuestion $cq)
    {
        $cq->name = $request['name'];
        $cq->description = $request['description'];

        $cq->save();

        return redirect('/admin/cqs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CodingQuestion  $codingQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(CodingQuestion $cq)
    {
        $cq->delete();
        return redirect('/admin/cqs');
    }
}
