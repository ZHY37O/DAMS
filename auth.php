<?php
session_start();
require "connect.php";
$uname = $_POST['username'];
$pass  = $_POST['password'];
$sql = "select user_id, username, sha256, idtype from pass where username = '" . $uname . '\';';
$r = $conn->query($sql)->fetchAll();
if (!empty($r)) {
foreach ($r as $row) {
    if ($row['sha256'] == hash("sha256",$pass)){
        $type = $row['idtype'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['idtype'] = $row['idtype'];
        $_SESSION['is_logged_in'] = 1;
        header('Location: /index.php');
        exit();
        
        return;
    }
};
}
header('Location: /login_form.php/?attempted=1');
# require 'index.php';
exit();
