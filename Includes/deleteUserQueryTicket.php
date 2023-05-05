<?php

if (isset($_POST["delete"][$_POST["delete"]["count"]."submit"])) {

    $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");

    if(mysqli_connect_errno()) {
        printf("Could not connect to DB: %s", mysqli_connect_error());
    } else {

        $query = "DELETE FROM userQueries WHERE Email = '".$_POST["delete"]["email"]."' AND queryDate = '".$_POST["delete"]["date"]."' AND time = '".$_POST["delete"]["time"]."'";

        $res = mysqli_query($sqlConnection, $query);

        if ($res == 1) {
            header("location: ../ticketPage.php");
        } else {
            echo "ERROR";
        }

        mysqli_close($sqlConnection);
    }
}

?>