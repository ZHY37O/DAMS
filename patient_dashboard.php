<?php
session_start();
require 'connect.php';

// Handle account deletion logic
if (isset($_GET['delete_account']) && $_GET['delete_account'] == 'confirm') {
    try {
        $userId = $_SESSION['user_id'];
        
        // Start a transaction
        $conn->beginTransaction();
        
        // 1. Delete appointments associated with the user
        $sqlAppointments = "DELETE FROM appointments WHERE patient_id = :userId";
        $stmtAppointments = $conn->prepare($sqlAppointments);
        $stmtAppointments->execute([':userId' => $userId]);
        
        // 2. Delete the patient record first due to foreign key constraint
        $sqlPatient = "DELETE FROM patient WHERE user_id = :userId";
        $stmtPatient = $conn->prepare($sqlPatient);
        $stmtPatient->execute([':userId' => $userId]);

        // 3. Delete the user's account
        $sqlAccount = "DELETE FROM account WHERE user_id = :userId";
        $stmtAccount = $conn->prepare($sqlAccount);
        $stmtAccount->execute([':userId' => $userId]);
        
        // Commit the transaction
        $conn->commit();
        
        // Destroy the session and redirect to the login page
        session_destroy();
        session_unset();
        header("Location: /login_form.php");
        exit();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error deleting account: " . $e->getMessage();
    }
}

try {
    $sql = "select a.name, p.week, p.time from appointments p, account a where p.doctor_id = a.user_id and p.patient_id = :patient_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':patient_id' => $_SESSION['user_id']
    ]);
    $appointments = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$weekdays = [
    0 => "Sunday",
    1 => "Monday",
    2 => "Tuesday",
    3 => "Wednesday",
    4 => "Thursday",
    5 => "Friday",
    6 => "Saturday"
];


$edit = 0;
if (isset($_SESSION['idtype']) and $_SESSION['idtype'] == 0) {
    $edit = 1;
}

$weekdays = [
    0 => "Sunday",
    1 => "Monday",
    2 => "Tuesday",
    3 => "Wednesday",
    4 => "Thursday",
    5 => "Friday",
    6 => "Saturday"
];




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script type="module" src="https://unpkg.com/cally"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>
<body class="bg-amber-200">
    <nav class="">
        <div class="shadow-lg navbar bg-sky-500">
            <div class="flex-1">
                <a class="text-xl btn btn-ghost">Patient dashboard</a>
            </div>
            <div class="flex gap-2">
                <form action="/search.php" method="GET" class="flex items-center gap-2">
                    <input type="text" name="query" placeholder="Search" class="w-24 input input-bordered md:w-auto" />
                    <button type="submit" class="btn btn-ghost btn-circle">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <div class="dropdown dropdown-end">
                    <button class="px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-red-700" onclick="location.href = '/logout.php/'">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>
     <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                        <li>
                            <a class="justify-between">
                                Profile
                                <span class="badge">New</span>
                            </a>
                        </li>
                        <li><a>Settings</a></li>
                        <li><a>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-6xl p-4 mx-auto">
        <section class="mt-10">
            <h1 class="mb-10 text-2xl"> Appointments </h1>

            <div class="overflow-x-auto bg-gray-400">
                <table class="table w-full table-zebra">
                <thead>
                    <tr class="text-gray-700 bg-zinc-400">
                        <th>Doctor Name</th>
                        <th>Week</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($appointments as $appointment): ?>
                    <tr>
                    <td><?=$appointment['name']?></td>
                    <td><?=$weekdays[$appointment['week']]?></td>
                    <td><?=$appointment['time']?></td>
                    </td>
                    </tr>
<?php endforeach; ?>
                </tbody>
                </table>
            </div>
        </section>

        <div class="flex justify-end m-10">
            <calendar-date class="border shadow-lg cally bg-base-100 border-base-300 rounded-box">
                <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M15.75 19.5 8.25 12l7.5-7.5"></path></svg>
                <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path></svg>
            </calendar-date>
        </div>
        <!-- Delete Account Section -->
        <section class="flex flex-col items-center p-6 mt-10 text-center bg-red-100 rounded-lg shadow-md">
            <h2 class="mb-4 text-xl font-bold text-red-800">Delete Account</h2>
            <p class="mb-6 text-red-700">Warning: Deleting your account is a permanent action and cannot be undone. All your data, including appointments, will be permanently removed.</p>
            <button class="btn btn-error" onclick="deleteModal.showModal()">
                <i class="fa-solid fa-user-xmark"></i>
                Delete Account
            </button>
        </section>

    </main>
    <!-- Modal for delete confirmation -->
    <dialog id="deleteModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Account Deletion</h3>
            <p class="py-4">Are you absolutely sure you want to delete your account? This action is irreversible.</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-ghost">Cancel</button>
                </form>
                <a href="?delete_account=confirm" class="btn btn-error">
                    Yes, Delete
                </a>
            </div>
        </div>
    </dialog>
</body>
</html>
