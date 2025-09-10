<?php
require 'connect.php';
try {
    if (isset($_POST['doctor_id'], $_POST['weekday'], $_POST['time'])) {
        $doctor_id = $_POST['doctor_id'];
        $weekday   = $_POST['weekday'];
        $time      = $_POST['time'];

        $sql = "INSERT INTO slot (doctor_id, week, time)
                VALUES (:doctor_id, :week, :time);";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':doctor_id'      => $doctor_id,
            ':week'        => $weekday,
            ':time' => $time
        ]);
        exit;
    } else {
        echo "Missing fields";
        exit;
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    exit;
}
