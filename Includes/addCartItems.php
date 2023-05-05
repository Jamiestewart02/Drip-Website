<?php

session_start();

if (isset ($_POST["add"]["submit"])) {

    $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");

    if (mysqli_connect_errno()) {
        printf("Could not connect to DB: %s", mysqli_connect_error());
    } else {

        if (isset($_POST["add"]["size"])) {
            $query = "SELECT product.Name, product.ProductID, product.ImagePath, product.Price, stock.Size FROM product 
                      JOIN stock ON product.ProductID = stock.ProductID
                      WHERE stock.Size = '". $_POST["add"]["size"]. "' AND product.ProductID = '". $_POST["add"]["product"]. "'";
        } else {
            $query = "SELECT * FROM product WHERE ProductID = '". $_POST["add"]["product"]. "'";
        }
        $res = mysqli_query($sqlConnection, $query);

        if ($res) {
            $array = mysqli_fetch_array($res, MYSQLI_ASSOC);
            $_SESSION["cartCount"]++;   
            $_SESSION["cart"][$_SESSION["cartCount"]] = $array;
            $_SESSION["cart"][$_SESSION["cartCount"]] += array("Quantity" => $_POST["add"]["quantity"]);
            $_SESSION["cart"][$_SESSION["cartCount"]]["Price"] = $_SESSION["cart"][$_SESSION["cartCount"]]["Price"] * $_POST["add"]["quantity"];
        }

        mysqli_close($sqlConnection);
        header("Location: ".$_SERVER["HTTP_REFERER"]."#shop");
    }
}

?>