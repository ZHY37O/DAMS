<?php
session_start()
?>
<h1> Welcome BOSS!!!</h1>
<h2> your admin id is <?= $_SESSION['user_id'] ?>
    <p> TODO: fetch admin info with id <?= $_SESSION['user_id'] ?> <br>
        develop ui.
    </p>
