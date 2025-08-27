<?php
require "connect.php";
$uname = $_POST['username'];
$pass  = $_POST['password'];
echo $uname . "<br>";
echo $pass . "<br>";

$sql = "select username, sha256 from pass where username = '" . $uname . '\';';
$r = $conn->query($sql)->fetchAll();
if (!empty($r)) {
foreach ($r as $row) {
    if ($row['sha256'] == hash("sha256",$pass)){
        echo "loged in as ".$row['username'];
        return;
    }
};
}
