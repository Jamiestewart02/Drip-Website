<?php

    session_start();

    if(isset($_POST["edit"]["delete"])) {

        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");


        if (mysqli_connect_errno()) {
            printf ("Could not connect to DB: %s", mysqli_connect_error());
        } else {
            $queryString = "DELETE FROM account WHERE AccountID = '".$_SESSION["account"]["AccountID"]."'";
            $update = mysqli_query($sqlConnection, $queryString);

            if ($update) {
                if(isset($_POST["edit"])) {
                    unset($_POST["edit"]);
                }
                unset($_SESSION["account"]);
            } 
        }
        mysqli_close($sqlConnection);
        header("Location: ../index.php");

    } else if (isset($_POST["edit"]["submit"])) {

        foreach($_POST["edit"] as $key => &$value) {
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
        }

        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");

        foreach($_POST["edit"] as $key => &$value) {
            $value = mysqli_real_escape_string($sqlConnection, $value);
        }

        if (mysqli_connect_errno()) {
            printf ("Could not connect to DB: %s", mysqli_connect_error());
        } else {
            $queryString = "UPDATE account
                            SET FirstName = '".$_POST["edit"]["firstName"].
                                "', LastName = '".$_POST["edit"]["lastName"].
                                "', Street = '".$_POST["edit"]["street"].
                                "', City = '".$_POST["edit"]["city"].
                                "', Country = '".$_POST["edit"]["country"].
                                "', Postcode = '".$_POST["edit"]["postcode"].
                                "', Email = '".$_POST{"edit"}["email"].
                            "' WHERE AccountID = '".$_POST["edit"]["id"]."'";

            $update = mysqli_query($sqlConnection, $queryString);

            if ($update) {
                if(isset($_POST["edit"])) {
                    unset($_POST["edit"]);
                }
            }

            $queryString = "SELECT * FROM account WHERE AccountID = '".$_SESSION["account"]["AccountID"]."'";

            $update = mysqli_query($sqlConnection, $queryString);

            if ($update) {
                $array = mysqli_fetch_array($update, MYSQLI_ASSOC);
                $_SESSION["account"] = $array;
            }

            mysqli_close($sqlConnection);
            header("location: ../index.php");
        }

    } else if (isset($_POST["password"]["submit"]) && ($_POST["password"]["new"] == $_POST["password"]["confirm"])) {

        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");

        if (mysqli_connect_errno()) {
            printf ("Could not connect to DB: %s", mysqli_error());
        } else {
            $query = "SELECT Password FROM account WHERE AccountID = '".$_SESSION["account"]["AccountID"]."'";
            $res = mysqli_query($sqlConnection, $query);

            if ($res) {
                $array = mysqli_fetch_array($res, MYSQLI_ASSOC);

                if (password_verify($_POST["password"]["old"], $array['Password'])) {

                    $newPassword = htmlspecialchars($_POST["password"]["new"]);
                    $newPassword = strip_tags($newPassword);
                    $newPassword = mysqli_real_escape_string($sqlConnection, $newPassword);
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    $queryString = "UPDATE account SET Password = '".$hashedPassword."' WHERE AccountID = '".$_SESSION["account"]["AccountID"]."'";
                    $update = mysqli_query($sqlConnection, $queryString);

                    if ($update) {
                        if (isset($_POST["password"])) {
                            unset($_POST["password"]);
                        }
                    } else {
                        echo "Password update failed.";
                    }

                    mysqli_close($sqlConnection);
                    header("location: ../index.php");
                }
            } else {
                echo "Password update failed.";
            }
        } 
    }
?>