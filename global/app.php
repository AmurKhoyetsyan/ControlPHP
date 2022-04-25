<?php

    use Lib\Session\Session;
    Session::runSession();

    use Lib\Route\Route;

    include_once basePath() . '/route/web.php';

    Route::run();