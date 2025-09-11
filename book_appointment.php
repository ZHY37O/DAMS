<?php
require 'connect.php';
try {
    if (isset($_POST['patient_id'],$_POST['doctor_id'] , $_POST['week'], $_POST['time'])) {
        $patient_id = $_POST['patient_id'];
        $doctor_id = $_POST['doctor_id'];
        $weekday   = $_POST['week'];
        $time      = $_POST['time'];

        $sql = "INSERT INTO appointments (patient_id, doctor_id, week, time)
                VALUES (:patient_id, :doctor_id, :week, :time);";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':doctor_id'      => $doctor_id,
            ':week'        => $weekday,
            ':time' => $time,
            ':patient_id' => $patient_id
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
