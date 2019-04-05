<?php

/*
 * Garage -- A code kata for the automobile owner
 *
 * Copyright (C) <2019> <Kyle Klaus>
 *
 * This software may be modified and distributed under the terms of the MIT license.  See the LICENSE file for details.
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
