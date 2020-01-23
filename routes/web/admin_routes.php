<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('admin.partials.layout');
});

Route::resource('mcqs', 'Admin\MultipleChoiceQuestionController');
Route::resource('tests', 'Admin\TestController');
