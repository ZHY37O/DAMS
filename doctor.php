<?php
session_start();
$doctor_username = $_GET['query'];
require 'connect.php';
try {
    $sql = "select name, user_id  from account where id_type = 2 and username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':username' => $doctor_username
    ]);
    $doctor = $stmt->fetchAll()[0];
    $stmt2 = $conn->prepare(
        "select week, time from slot where doctor_id = :user_id;"
    );
    $stmt2->execute([
        ':user_id' => $doctor['user_id']
    ]);
    $slots = $stmt2->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
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


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script type="module" src="https://unpkg.com/cally"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>


<h1> <?= $doctor['name'] ?> </h1>

<h2> Slots </h2>
<table class="table w-full">
    <thead>
        <tr class="text-gray-700 bg-gray-100">
            <th class="text-left">DAY</th>
            <th class="text-left">TIME SLOTS</th>
            <?php if (!$edit): ?>
                <th class="text-left">BOOK APPOINTMENT</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($slots as $slot): ?>
            <tr>
                <td><?= htmlspecialchars($weekdays[$slot['week']]) ?></td>
                <td><?= htmlspecialchars($slot['time']) ?></td>
                <?php if (!$edit): ?>
                    <td><button class='button' onclick="pbook(<?= $_SESSION['user_id'] ?>, <?= $doctor['user_id'] ?>, <?= $slot['week'] ?>, '<?= $slot['time'] ?>')"><i class='fa-solid fa-book hover:bg-red-200'></i></button></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p id="response"></p>
<script>
    function pbook(patient_id, doctor_id, week, time) {
        let formData = new FormData()
        let resp = document.querySelector("#response");
        formData.append('patient_id', patient_id)
        formData.append('doctor_id', doctor_id)
        formData.append('week', week)
        formData.append('time', time)

        fetch("/book_appointment.php", {
                method: "POST",
                body: formData
            }).then(res => res.text())
            .then(data => {
                resp.innerText = data;
                alert("appointmet added")
            })

    }
</script>


<?php if ($edit): ?>
    <form id="form">
        <input type="hidden" name="doctor_id" value=<?= $doctor['user_id'] ?>>
        <div class='form-control'>
            <label for="weekday">Choose a Week:</label>
            <select id="weekday" name="weekday" class="select">
                <option value=0>Sunday</option>
                <option value=1>Monday</option>
                <option value=2>Tuesday</option>
                <option value=3>Wednesday</option>
                <option value=4>Thursday</option>
                <option value=5>Friday</option>
                <option value=6>Saturday</option>
            </select>
        </div>
        <div class='form-control'>
            <label for="time">Choose a time:</label>
            <input type="time" id="time" name="time" class="input">
        </div>
    </form>
    <button onclick='ppost()' class="Button bg-green-700 hover:bg-red-700 rounded" id='button'> add </button>


    <script>
        function ppost() {
            let form = document.querySelector("#form");
            let resp = document.querySelector("#response");
            let formData = new FormData(form);
            let weekday = form.weekday.value
            let time = form.time.value
            if (!weekday) {
                alert("Please select a weekday.");
                return;
            }

            if (!time) {
                alert("Please select a valid time.");
                return;
            }

            fetch("/add_slot.php", {
                    method: "POST",
                    body: formData
                }).then(res => res.text())
                .then(data => {
                    resp.innerText = data;
                    location.reload()
                })
        }
    </script>

<?php endif; ?>
