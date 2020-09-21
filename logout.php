<?php

session_start();
require_once 'app/helpers.php';

if( !user_connected() ){

    header('location: signin.php');
    exit;

}

session_destroy();
session_start();
work_sess('warning','You have successfully logged out !!!');
header('location: signin.php');