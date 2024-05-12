<?php

use App\Support\Route;

Route::post('/leanplum/api', 'LeanplumController@actionMulti')->setName('postActionMulti');
