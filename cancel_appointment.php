<?php
require 'connect.php';
try {
    if (isset($_POST['appointment_id'])) {
        $appointment_id = $_POST['appointment_id'];
        
        $sql = "Delete from appointments where appointment_id=:appointment_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':appointment_id'      => $appointment_id
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
