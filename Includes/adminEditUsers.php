<?php

    session_start();

    function updateAccount($sqlConnection, $queryString) {

        $update = mysqli_query($sqlConnection, $queryString);

        if ($update) {
            if(isset($_POST["adminEdit"])) {
                unset($_POST["adminEdit"]);
            }
        }

        mysqli_close($sqlConnection);
        header("location: ../adminAccountsPage.php");
    }

    if(isset($_POST["adminEdit"][$_POST["adminEdit"]["id"]."delete"])) {

        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");


            if (mysqli_connect_errno()) {
                printf ("Could not connect to DB: %s", mysqli_connect_error());
            } else {
                $queryString = "DELETE FROM account WHERE AccountID = '".$_POST["adminEdit"]["id"]."'";
                updateAccount($sqlConnection, $queryString);
            }

    } else if (isset($_POST["adminEdit"][$_POST["adminEdit"]["id"]."submit"])) {

        foreach($_POST["adminEdit"] as $key => &$value) {
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
        }

        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");

        foreach($_POST["adminEdit"] as $key => &$value) {
            $value = mysqli_real_escape_string($sqlConnection, $value);
        }

        if (mysqli_connect_errno()) {
            printf ("Could not connect to DB: %s", mysqli_connect_error());
        } else {
            $queryString = "UPDATE account
                            SET FirstName = '".$_POST["adminEdit"]["firstName"].
                                "', LastName = '".$_POST["adminEdit"]["lastName"].
                                "', Street = '".$_POST["adminEdit"]["street"].
                                "', City = '".$_POST["adminEdit"]["city"].
                                "', Country = '".$_POST["adminEdit"]["country"].
                                "', Postcode = '".$_POST["adminEdit"]["postcode"].
                                "', Email = '".$_POST{"adminEdit"}["email"].
                            "' WHERE AccountID = '".$_POST["adminEdit"]["id"]."'";
            updateAccount($sqlConnection, $queryString);
        }
    }
?>