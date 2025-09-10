<?php
session_start();
if (!($_SESSION['is_logged_in'] ?? 0)) {
    header('Location: login_form.php');
    exit();
} else {
    switch ($_SESSION['idtype']) {
        case 0:
            header('Location: /admin_dashboard.html/');
            exit();
        case 1:
            header('Location: /patient_dashboard.php/');
            exit();
        case 2:
            header('Location: /doctor_dashboard.html/');
            exit();
    }
}
