<?php
session_start();
require "connect.php";
$uname = $_POST['username'];
$pass  = $_POST['password'];
$sql = "select user_id, id_type, pswd_hash from account where username = '" . $uname . '\';';
$r = $conn->query($sql)->fetchAll();
if (!empty($r)) {
foreach ($r as $row) {
    if ($row['pswd_hash'] == hash("sha256",$pass)){
        $type = $row['id_type'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['idtype'] = $row['id_type'];
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
