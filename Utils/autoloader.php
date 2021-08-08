<?php

ini_set("display_errors", 1);

spl_autoload_register(function ($class){
    $name = str_replace('\\', '/', $class);
    $name .= '.php';
    
    require_once "../".$name;
});