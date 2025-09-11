<?php
$req = $_SERVER['REQUEST_URI'];

switch ($req) {
case '/':
    require 'index.php';
    break;
default:
    return false;
}
        
