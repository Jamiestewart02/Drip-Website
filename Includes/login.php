<!-- Apply sign in to database -->
<?php

if (isset($_POST["signInSubmit"])) {

    session_start();
    $_SESSION["email"] = htmlspecialchars($_POST["signInEmail"]);

    $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");
    $email = mysqli_real_escape_string($sqlConnection, $_POST["signInEmail"]);
    $password = mysqli_real_escape_string($sqlConnection, $_POST["signInPassword"]);
    

    if (mysqli_connect_errno()) {
        printf("Connection to DB failed: %s \n", mysqli_connect_error());
    } else {

        // Retrieve only the password from the database
        $sql = "SELECT Password FROM account WHERE Email = '$email'";

        $res = mysqli_query($sqlConnection, $sql);
        $count = mysqli_num_rows($res);
        $array = mysqli_fetch_array($res, MYSQLI_ASSOC);

        // Verify the provided password against the hashed password from the database
        if (password_verify($password, $array['Password'])) {
            // Retrieve the rest of the user data after verifying the password
            $sql = "SELECT * FROM account WHERE Email = '$email'";
            $res = mysqli_query($sqlConnection, $sql);
            $array = mysqli_fetch_array($res, MYSQLI_ASSOC);

            session_start();
            unset($_SESSION["error"]);
            $_SESSION["account"] = $array;
            $_SESSION["cartCount"];
            if ($array["AdminID"] != null ) {
                $_SESSION["adminID"] = $array["AdminID"];
            }
            header("location: ../index.php");
        } else {
            header("location: ../index.php?wrongCredentials=Incorrect+email+or+password");
        }
    }
} else {
    session_start();

    if(isset($_SESSION["email"])) {
        unset($_SESSION["email"]);
    }

    header("location: ../index.php");
}


?>