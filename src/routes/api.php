<?php


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/', '\Woodoocoder\LaravelDialogs\Controllers\DialogsController@store');
    Route::put('/{dialog}', '\Woodoocoder\LaravelDialogs\Controllers\DialogsController@update');
    Route::get('/', '\Woodoocoder\LaravelDialogs\Controllers\DialogsController@index');
    Route::get('/{dialog}', '\Woodoocoder\LaravelDialogs\Controllers\DialogsController@show');
    Route::delete('/{dialog}', '\Woodoocoder\LaravelDialogs\Controllers\DialogsController@destroy');
    Route::put('/mark_reed/{dialog}', '\Woodoocoder\LaravelDialogs\Controllers\DialogsController@mark_reed');

    
    Route::group(['prefix' => '{dialog}/messages'], function () {
        Route::post('/', '\Woodoocoder\LaravelDialogs\Controllers\MessagesController@store');
        Route::put('/{message}', '\Woodoocoder\LaravelDialogs\Controllers\MessagesController@update');
        Route::get('/', '\Woodoocoder\LaravelDialogs\Controllers\MessagesController@index');
        Route::get('/{message}', '\Woodoocoder\LaravelDialogs\Controllers\MessagesController@show');
        Route::delete('/{message}', '\Woodoocoder\LaravelDialogs\Controllers\MessagesController@destroy');
    });

    Route::group(['prefix' => '{dialog}/participants'], function () {
        Route::get('/', '\Woodoocoder\LaravelDialogs\Controllers\ParticipantsController@index');
    });
});
