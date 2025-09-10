<?php
require "connect.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name     = $_POST['Full_name'] ?? null;
    $dob           = $_POST['Date_Of_birth'] ?? null;
    $gender        = $_POST['Gender'] ?? null;
    $blood_group   = $_POST['blood_Group'] ?? null;
    $address       = $_POST['Address'] ?? null;
    $phone_number  = $_POST['Phone_number'] ?? null;
    $user_name     = $_POST['user_name'] ?? null;
    $email         = $_POST['email'] ?? null;
    $password_raw  = $_POST['password'] ?? null;
    $password_hashed = hash("sha256", $password_raw);
}

$sql_insert_account = "INSERT INTO account 
                (email,id_type,address,phone,gender,username,name,pswd_hash,DoB)
                VALUES 
                (:email,:id_type,:address,:phone,:gender,:username,:name,:pswd_hash,:DoB);";
$sql_insert_patient = "INSERT INTO patient
                (user_id,blood_type)
                VALUES
                (:user_id,:blood_type);";


try {
    $stmt1 = $conn->prepare($sql_insert_account);
    $stmt2 = $conn->prepare($sql_insert_patient);
    $conn->beginTransaction();
    $stmt1->execute([
        ':email'        => $email,
        ':id_type' => 1,
        ':address'      => $address,
        ':phone' => $phone_number,
        ':gender'       => $gender,
        ':username'    => $user_name,
        ':name'    => $full_name,
        ':pswd_hash'     => $password_hashed,
        ':DoB' => $dob,
    ]);
    $stmt2->execute([
        ':user_id' => $conn->lastInsertId(),
        ':blood_type' => $blood_group
    ]);
    $conn->commit();
    
    
    echo "Registration successful!";
} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    
    echo "Database Error: " . $e->getMessage();
}
