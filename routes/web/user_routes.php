<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'User\TestController@view');
Route::post('/take_test/{test}', 'User\TestController@takeTest');
