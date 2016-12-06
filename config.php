<?php

//SETTINGS
session_name('pod-vf');
session_start();

set_time_limit(0);
date_default_timezone_set('America/Fortaleza');

ini_set('display_errors', 1);
error_reporting( E_ALL ^ E_NOTICE );

set_exception_handler(function($e)
{
    include_once 'partials/error.php';
});

//LOAD
include_once 'functions.php';

include_once 'trees/Binary.php';
include_once 'trees/AVL.php';
include_once 'trees/RB.php';
