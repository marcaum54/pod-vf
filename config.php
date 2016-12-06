<?php

//SETTINGS
session_name('pod-vf');
session_start();

set_time_limit(0);
date_default_timezone_set('America/Fortaleza');

set_exception_handler(function($e)
{
    include_once 'partials/error.php';
});

//LOAD
include_once 'functions.php';

include_once 'trees/Binary.php';
include_once 'trees/AVL.php';
include_once 'trees/RB.php';
