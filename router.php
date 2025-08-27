<?php
$req = $_SERVER['REQUEST_URI'];

echo $req;
switch ($req) {
case '/':
    echo "hello";
}
        
