<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'User\TestController@view');
Route::post('/take_test/{test}', 'User\TestController@takeTest');
Route::get('/test/{testresponse}', 'User\TestController@test')->name('user.test');
Route::post('/finish_test/{testresponse}', 'User\TestController@finishTest');
Route::get('/runcode', 'User\TestController@runCode');
