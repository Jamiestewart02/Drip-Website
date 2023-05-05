<?php

function contact($name, $email, $subject, $message) {
    $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");


    $message = htmlspecialchars($message);

    $name = mysqli_real_escape_string($sqlConnection, $name);
    $email = mysqli_real_escape_string($sqlConnection, $email);
    $subject = mysqli_real_escape_string($sqlConnection, $subject);
    $message = mysqli_real_escape_string($sqlConnection, $message);
    $date = date("Y.m.d");
    $time = date("H:i:s");

    $query = "INSERT INTO userqueries VALUES ('$name', '$email', '$subject', '$message', '$date', '$time')";

    $res = mysqli_query($sqlConnection, $query);

    if ($res== 1) {
        echo "Your message has been sent!";
    }

    mysqli_close($sqlConnection);
}
?>