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




?>
<h1> <?= $doctor['name'] ?> </h1>
    <p> TODO: fetch doctor info with id <?= $_SESSION['user_id'] ?> <br>
        develop ui.
    </p>

    <h4> Slots </h4>
    <table class="table">
    <?php foreach ($slots as $slot): ?>
    <tr onclick='location.href = "/doctor.php/?query=<?=$doctor['username']?>"'>
    <td><?= htmlspecialchars($slot['week']) ?></td>
    <td><?= htmlspecialchars($slot['time']) ?></td>
    </tr>    
    <?php endforeach; ?>
    </table>

    
<?php if ($edit): ?>
    <form id = "form">
<label for="weekday">Choose a Week:</label>
      <input type="hidden" name="doctor_id" value=<?= $doctor['user_id'] ?>>
<select id="weekday" name="weekday" class="select">
  <option value=0>Sunday</option>
  <option value=1>Monday</option>
  <option value=2>Tuesday</option>
  <option value=3>Wednesday</option>
  <option value=4>Thursday</option>
  <option value=5>Friday</option>
  <option value=6>Saturday</option>
</select>
  <label for="time">Choose a time:</label>
  <input type="time" id="time" name="time" class="input">
    </form>
  <button onclick='ppost()' class = "button" id = 'button'> add </button>


<p id="response"></p>
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
