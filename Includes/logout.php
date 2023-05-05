<?php
    session_start();

    if(isset($_POST["signOutSubmit"])) {
        session_destroy();
        header("location: ../index.php");
    }
?>