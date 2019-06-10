<?php

$DATABASE = array(
    
    "host" => "localhost",
    "username" => "root",
    "password" => "Admin2015",
    "dbname" =>"ctfusers"
);

$db = new mysqli($DATABASE['host'],$DATABASE['username'],$DATABASE['password'],$DATABASE['dbname']);
