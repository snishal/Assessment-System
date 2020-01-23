<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MultipleChoiceQuestion;
use Illuminate\Http\Request;

class MultipleChoiceQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mcqs = MultipleChoiceQuestion::all();

        if($request->ajax()){

            $response = [];

            foreach($mcqs as $mcq){
                array_push($response, [
                    'name' => $mcq->text,
                    'value' => $mcq->id,
                    'text' => 'Question '.$mcq->id,
                ]);
            }

            return [
                'success' => true,
                'results' => $response,
            ];
        }

        return view('admin.mcqs.view', [
            'mcqs' => $mcqs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.mcqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // media_path to be added;
        MultipleChoiceQuestion::create(request(['text', 'option1', 'option2', 'option3', 'option4', 'correct_option']));

        // return redirect()->back()->withErrors($validator)->withInput();
        return redirect('/admin/mcqs');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MultipleChoiceQuestion  $multipleChoiceQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MultipleChoiceQuestion $mcq)
    {
        return $mcq;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MultipleChoiceQuestion  $multipleChoiceQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(MultipleChoiceQuestion $mcq)
    {
        return view('admin.mcqs.edit', [
            'mcq' => $mcq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MultipleChoiceQuestion  $multipleChoiceQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MultipleChoiceQuestion $mcq)
    {
        $mcq->text = $request['text'];
        $mcq->option1 = $request['option1'];
        $mcq->option2 = $request['option2'];
        $mcq->option3 = $request['option3'];
        $mcq->option4 = $request['option4'];
        $mcq->correct_option = $request['correct_option'];

        $mcq->save();

        return redirect('/admin/mcqs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MultipleChoiceQuestion  $multipleChoiceQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(MultipleChoiceQuestion $mcq)
    {
        $mcq->delete();
        return redirect('/admin/mcqs');
    }
}
