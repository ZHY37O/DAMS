<?php
$req = $_SERVER['REQUEST_URI'];

switch ($req) {
case '/':
    header('Content-Type: text/html');
    readfile('index.html');
    break;
default:
    return false;
}
        
