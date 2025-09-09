<?php
require "connect.php";
$uname = $_POST['username'];
$pass  = $_POST['password'];
$sql = "select user_id, username, sha256, idtype from pass where username = '" . $uname . '\';';
$r = $conn->query($sql)->fetchAll();
if (!empty($r)) {
foreach ($r as $row) {
    if ($row['sha256'] == hash("sha256",$pass)){
        $type = $row['idtype'];
        if ($type == 0) {
            header('Location: /admin.php/?id='.$row['user_id']);
            exit();
        } elseif ($type == 1) {
            header('Location: /patient.php/?id='.$row['user_id']);
            exit();
        } else {
            header('Location: /doctor.php/?id='.$row['user_id']);
            exit();
        }
        return;
    }
};
}
header('Location: /index.php/?attempted=1');
# require 'index.php';
exit();
