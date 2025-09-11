<?php
session_start()
?>

<h1> Welcome To DAMS.</h1>
    <h2> your patient id is <?= $_SESSION['user_id'] ?>
    <p> TODO: fetch patient info with id <?= $_SESSION['user_id']?> <br>
     develop ui.
    </p>
