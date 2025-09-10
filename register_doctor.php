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
    
    $specialization    = $_POST['specialist'] ?? null;
    $years_of_experience       = $_POST['experience_year'] ?? null;
    $license_id    = $_POST['license_id'] ?? null;
}

$sql_insert_account = "INSERT INTO account 
                (email,id_type,address,phone,gender,username,name,pswd_hash,DoB)
                VALUES 
                (:email,:id_type,:address,:phone,:gender,:username,:name,:pswd_hash,:DoB);";
$sql_insert_doctor = "INSERT INTO doctor
                (user_id,date_joined,specialization,license_id,years_of_experience)
                VALUES
                (:user_id,:date_joined,:specialization,:license_id,:years_of_experience);";


try {
    $stmt1 = $conn->prepare($sql_insert_account);
    $stmt2 = $conn->prepare($sql_insert_doctor);
    $conn->beginTransaction();
    $stmt1->execute([
        ':email'        => $email,
        ':id_type' => 2,
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
        ':date_joined' => date('Y-m-d'),
         ':specialization' => $specialization,
         ':license_id' => $license_id,
        ':years_of_experience' => $years_of_experience
    ]);
    $conn->commit();
    
    
    echo "Registration successful!";
} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    
    echo "Database Error: " . $e->getMessage();
}
