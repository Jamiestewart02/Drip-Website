<?php
    if (isset($_POST["registerSubmit"])) {
            $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");


            $accID = "US". rand(10000, 99999);

            $query = "SELECT * FROM account WHERE AccountID = '$accID'";
            $res = mysqli_query($sqlConnection, $query);
            $count = mysqli_num_rows($res);

            while ($count > 0) {
                $accID = "US". rand(10000, 99999);
                $res = mysqli_query($sqlConnection, $query);
                $count = mysqli_num_rows($res);
            }

            foreach($_POST["register"] as $key => &$value) {
                $value = strip_tags($value);
                $value = htmlspecialchars($value);
            }

            $query = "SELECT Email FROM account WHERE Email = '". $_POST["register"]["email"]. "'";
            $res = mysqli_query($sqlConnection, $query);
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                header("Location: ../registerPage.php?EmailAlreadyExists=true");
                exit();
            }

            $array["AccountID"] = $accID;
            $array["FirstName"] = mysqli_real_escape_string($sqlConnection, $_POST["register"]["firstName"]);
            $array["LastName"] = mysqli_real_escape_string($sqlConnection, $_POST["register"]["lastName"]);
            $array["Street"] = mysqli_real_escape_string($sqlConnection, $_POST["register"]["street"]);
            $array["City"] = mysqli_real_escape_string($sqlConnection, $_POST["register"]["city"]);
            $array["Country"] = mysqli_real_escape_string($sqlConnection, $_POST["register"]["country"]);
            $array["Postcode"] = mysqli_real_escape_string($sqlConnection, $_POST["register"]["postcode"]);
            $array["Email"] = mysqli_real_escape_string($sqlConnection, $_POST["register"]["email"]);
            $array["Password"] = mysqli_real_escape_string($sqlConnection, $_POST["register"]["password"]);
            $hashedPassword = password_hash($array["Password"], PASSWORD_DEFAULT);

            $query = "INSERT INTO account VALUES ('".$array["AccountID"]."', null, '".$array["FirstName"]."', '".$array["LastName"]."', '".$array["Street"]."', '".$array["City"]."', '".$array["Country"]."', '".$array["Postcode"]."', '".$array["Email"]."', '".$hashedPassword."')";
            $res = mysqli_query($sqlConnection, $query);

            if ($res == 1) {
                session_start();
                $_SESSION["account"] = $array;
                header("location: ../index.php");
            }
    } else if (isset($_POST["newUserSubmit"])) {

        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");


        $accID = "US". rand(10000, 99999);

        $query = "SELECT * FROM account WHERE AccountID = '$accID'";
        $res = mysqli_query($sqlConnection, $query);
        $count = mysqli_num_rows($res);

        while ($count > 0) {
            $accID = "US". rand(10000, 99999);
            $res = mysqli_query($sqlConnection, $query);
            $count = mysqli_num_rows($res);
        }

        foreach($_POST["newUser"] as $key => &$value) {
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
        }

        $query = "SELECT Email FROM account WHERE Email = '". $_POST["newUser"]["email"]. "'";
        $res = mysqli_query($sqlConnection, $query);
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            header("Location: ".$_SERVER["HTTP_REFERER"]."?EmailAlreadyExists=true");
            exit();
        }

        $array["AccountID"] = $accID;
        $array["FirstName"] = mysqli_real_escape_string($sqlConnection, $_POST["newUser"]["firstName"]);
        $array["LastName"] = mysqli_real_escape_string($sqlConnection, $_POST["newUser"]["lastName"]);
        $array["Street"] = mysqli_real_escape_string($sqlConnection, $_POST["newUser"]["street"]);
        $array["City"] = mysqli_real_escape_string($sqlConnection, $_POST["newUser"]["city"]);
        $array["Country"] = mysqli_real_escape_string($sqlConnection, $_POST["newUser"]["country"]);
        $array["Postcode"] = mysqli_real_escape_string($sqlConnection, $_POST["newUser"]["postcode"]);
        $array["Email"] = mysqli_real_escape_string($sqlConnection, $_POST["newUser"]["email"]);
        $array["Password"] = mysqli_real_escape_string($sqlConnection, $_POST["newUser"]["password"]);
        $hashedPassword = password_hash($array["Password"], PASSWORD_DEFAULT);

        $query = "INSERT INTO account VALUES ('".$array["AccountID"]."', null, '".$array["FirstName"]."', '".$array["LastName"]."', '".$array["Street"]."', '".$array["City"]."', '".$array["Country"]."', '".$array["Postcode"]."', '".$array["Email"]."', '".$hashedPassword."')";
        $res = mysqli_query($sqlConnection, $query);

        if ($res == 1) {
            header("Location: ". $_SERVER["HTTP_REFERER"]."?AccountCreated=true");
        }
    }
?>