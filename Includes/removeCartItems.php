<?php

    session_start();
    if (isset($_POST["cartDelete"])) {

        foreach ($_SESSION["cart"] as $key => $value) {
            if($_POST["cartProductID"] === $value["ProductID"] && $_POST["cartProductSize"] === $value["Size"]) {
                unset($_SESSION["cart"][$key]);
                $_SESSION["cartCount"]--;
            }
        }
        header("location: ".$_SERVER["HTTP_REFERER"]);
    }
?>