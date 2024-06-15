<?php

use App\Support\Route;

Route::get('/', 'HomeController@index')->setName('index');

Route::get('/phpinfo', 'HomeController@phpInfo')->setName('phpinfo');
Route::get('/direct', 'HomeController@direct')->setName('direct');

