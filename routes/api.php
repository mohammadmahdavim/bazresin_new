<?php

// For Authentication
Route::post('/v1/login',['uses' => 'Api\v1\auth\AuthController@login']);
Route::post('/v1/registerStep1',['uses' => 'Api\v1\auth\AuthController@registerStep1']);
Route::post('/v1/registerStep2',['uses' => 'Api\v1\auth\AuthController@registerStep2']);
Route::post('/v1/registerStep3',['uses' => 'Api\v1\auth\AuthController@registerStep3']);
Route::get('/v1/checkToken',['uses' => 'Api\v1\auth\AuthController@checkToken']);
// End



// For Application
Route::prefix('v1')->namespace('Api\v1')->middleware('auth:api')->group(function () {
    Route::get('/exams', 'ExamsController@exams');
    Route::get('/poshtibans/{id}', 'ExamsController@poshtibans');
});
// End

// For Site

// End


// For User

// End


// For Admin

// End


