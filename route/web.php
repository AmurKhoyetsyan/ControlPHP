<?php
    use Lib\Route\Route;

    Route::get('/', function() {
        return view('welcome');
    });