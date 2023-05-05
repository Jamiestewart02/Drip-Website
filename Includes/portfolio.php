 <!-- ======= Portfolio Section ======= -->
<?php
    function displaySizes ($productID, $sqlConnection) {

        $query = "SELECT * FROM stock WHERE ProductID = '". $productID."' AND Amount > 0 ORDER BY Size DESC";
        $res = mysqli_query($sqlConnection, $query);
        $count = mysqli_num_rows($res);

        if($count > 0) {

            if (str_contains($productID, 'ACC')) {
            
?>
                <form action="Includes/addCartItems.php" method="post">

                    <div class ="row mb-3 justify-content-center">
                        <div class="col-md-7">
                            <h4>Quantity</h4>
                            <select name="add[quantity]" class="form-select">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>

                    <?php 
                        $available = true;

                        if (isset($_SESSION["cart"])) {
                            foreach($_SESSION["cart"] as $key => $value) {
                                if ($value["ProductID"] == $productID) {
                                    $available = false;
                                }
                            }
                        }

                        if ($available) { ?>
                            <input type="hidden" name="add[product]" value="<?php echo $productID; ?>">
                            <button type="submit" name="add[submit]" class="btn btn-secondary text-light">Add to Basket</button>
                <?php   } else { ?>
                            <p class="text-danger">This item is already in your cart</p>
                <?php   } ?>
                </form>
        <?php
            } else {
        ?>
                <form action="Includes/addCartItems.php" method="post">
                    <div class="row mb-3 justify-content-center">
                        <div class="col-md-5">
                            <h4>Size</h4>
                            <select name="add[size]" id="" class="form-select mb-3" required>
                        <?php
                            while ($array = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                $availableSize = true;
                                $available = true;

                                if(isset($_SESSION["cart"])) {
                                    $available = false;
                                    foreach($_SESSION["cart"] as $key => $value) {
                                        if ($value["ProductID"] == $productID && $value["Size"] == $array["Size"]) {
                                            $availableSize = false;
                                        }
                                    }
                                }

                                if ($array["Amount"] == 0) {
                                    $availableSize = false;
                                }

                                if($availableSize) {
                                    echo "<option value='".$array["Size"]."'>".$array["Size"]."</option>";
                                    $available = true;
                                }
                                
                            }
                        ?>  </select>
                        </div>
                        
                        <div class="col-md-5">
                            <h4>Quantity</h4>
                            <select name="add[quantity]" class="form-select">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
        <?php   if ($available) { ?>
                    <input type="hidden" name="add[product]" value="<?php echo $productID; ?>">
                    <div class="modal-footer d-flex justify-content-center row-mb-3">
                        <button type="submit" name="add[submit]" class="btn btn-secondary text-light">Add to Basket</button>
                    </div>
        <?php   } else { ?>
                    <p class="text-danger">Sorry, this item is unavailable</p>
        <?php   }   ?>
            </form>
            <?php   
            } 
        } else {
    ?>      <p class="text-danger">Sorry, this item is currently out of stock.</p>
<?php
        }
    }
    ?>



<?php

    function displayClothes($filter) {
        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");


        if (mysqli_connect_errno()) {
            printf("Connection to DB failed: %s \n", mysqli_connect_error());
        } else {
            $query = "SELECT * FROM product WHERE ProductID LIKE '%{$filter}%'";
            $res = mysqli_query($sqlConnection, $query);
            
            while($array = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                $itemID = $array["ProductID"];
                $name = $array["Name"];
                $price = $array["Price"];
                $image = $array["ImagePath"];
                $altImage = $array["AltImagePath"];
                $altImageTwo = $array["AltImagePathTwo"];
                $imageID = "#". $itemID. "Image";
                $description = $array["Description"];
                ?>

                <div class='col-xl-4 col-md-6 portfolio-item filter-mens'>
                    <div class='portfolio-wrap'>
                        <a href="<?php echo $image; ?>" data-gallery='portfolio-gallery-app' class='glightbox'><img src="<?php echo $image; ?>" class='img-fluid' alt=''></a>
                        <div class='portfolio-info'>
                            <h4><a href="<?php echo $url; ?>" data-bs-toggle='modal' class='text-success' data-bs-target="<?php echo "#".$itemID."Modal"; ?>"><?php echo $name; ?></a></h4>
                            <h5><?php printf("£%0.2f", $price); ?></h5>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="<?php echo $itemID."Modal"; ?>" tabindex="-1" data-backdrop="false" aria-labelledby="clothesModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productNameModalLabel"><?php echo $name; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <!--Main Image-->
                                    <div class="row">
                                        <div class="col-md-9 col-sm-6 col-xs-12 mb-3">
                                            <img src="<?php echo $image; ?>" alt="" id="<?php echo $itemID."Image"; ?>" class="img-fluid main-img" style="height: 500px;">
                                        </div>
                                        <!--Thumbnails-->
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                                    <img src="<?php echo $image; ?>" alt="" class="img-fluid img-thumbnail thumb-img" onclick="document.querySelector('<?php echo $imageID; ?>').src = this.src;">
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                                    <img src="<?php echo (isset($altImage)) ? $altImage : ""; ?>" alt="" class="img-fluid img-thumbnail thumb-img" onclick="document.querySelector('<?php echo $imageID; ?>').src = this.src;">
                                                </div>
                                                <?php if (isset($altImageTwo)) { ?>
                                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                                    <img src="<?php echo (isset($altImageTwo)) ? $altImageTwo : ""; ?>" alt="" class="img-fluid img-thumbnail thumb-img" onclick="document.querySelector('<?php echo $imageID; ?>').src = this.src;">
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="hr-splitter" />

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                            <form action="reviewDisplay.php" method="get">
                                                <input type="hidden" name="reviewItem" value="<?php echo $itemID; ?>">
                                                <input type="hidden" name="reviewName" value="<?php echo $name; ?>">
                                                <button type="submit" name="reviewSubmit" style="background-color: #ffffff; border: none; font-weight: 600" class="text-success mb-3">Customer Reviews</button>
                                            </form>
                                            <h4>Product Description</h4>
                                            <p class="tab">
                                                <?php echo $description; ?>
                                            </p>
                                            <h4>Price</h4>
                                            <p class="tab">
                                                <?php printf("£%0.2f", $price); ?>
                                            </p>
                                            <?php displaySizes($itemID, $sqlConnection); ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        <?php
            }     
            mysqli_close($sqlConnection);
        }
    }
?>

<?php
    function returnSearchItems($searchTag) {

        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");
        $searchTag = mysqli_real_escape_string($sqlConnection, $searchTag);

        if (mysqli_connect_errno()) {
            printf("Connection to DB failed: %s \n", mysqli_connect_error());
        } else {
            $query = "SELECT * FROM product WHERE Tags LIKE '%{$searchTag}%' OR Description LIKE '%{$searchTag}%'";
            $res = mysqli_query($sqlConnection, $query);
            
            while($array = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                $itemID = $array["ProductID"];
                $name = $array["Name"];
                $price = $array["Price"];
                $image = $array["ImagePath"];
                $altImage = $array["AltImagePath"];
                $altImageTwo = $array["AltImagePathTwo"];
                $imageID = "#". $itemID. "Image";
                $description = $array["Description"];

                //=========Item Box==========

                echo "<div class='col-xl-4 col-md-6 portfolio-item filter-mens'>";
                echo "<div class='portfolio-wrap'>";
                echo "<a href=".$image." data-gallery='portfolio-gallery-app' class='glightbox'><img src='".$image."' class='img-fluid' alt=''></a>";
                echo "<div class='portfolio-info'>"; ?>
                <h4><a href="<?php echo $url; ?>" data-bs-toggle='modal' class='text-success' data-bs-target="<?php echo "#".$itemID."Modal"; ?>"><?php echo $name; ?></a></h4> <?php
                printf ("£%0.2f", $price);
                echo "</div></div></div>"; ?>

                <!--------Modal Box------->

                <div class="modal fade" id="<?php echo $itemID."Modal"; ?>" tabindex="-1" data-backdrop="false" aria-labelledby="clothesModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productNameModalLabel"><?php echo $name; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <!--Main Image-->
                                    <div class="row">
                                        <div class="col-md-9 col-sm-6 col-xs-12 mb-3">
                                            <img src="<?php echo $image; ?>" alt="" id="<?php echo $itemID."Image"; ?>" class="img-fluid main-img" style="height: 500px;">
                                        </div>
                                        <!--Thumbnails-->
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                                    <img src="<?php echo $image; ?>" alt="" class="img-fluid img-thumbnail thumb-img" onclick="document.querySelector('<?php echo $imageID; ?>').src = this.src;">
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                                    <img src="<?php echo (isset($altImage)) ? $altImage : ""; ?>" alt="" class="img-fluid img-thumbnail thumb-img" onclick="document.querySelector('<?php echo $imageID; ?>').src = this.src;">
                                                </div>
                                                <?php if (isset($altImageTwo)) { ?>
                                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                                    <img src="<?php echo (isset($altImageTwo)) ? $altImageTwo : ""; ?>" alt="" class="img-fluid img-thumbnail thumb-img" onclick="document.querySelector('<?php echo $imageID; ?>').src = this.src;">
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="hr-splitter" />

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                            <form action="reviewDisplay.php" method="get">
                                                <input type="hidden" name="reviewItem" value="<?php echo $itemID; ?>">
                                                <input type="hidden" name="reviewName" value="<?php echo $name; ?>">
                                                <button type="submit" name="reviewSubmit" style="background-color: #ffffff; border: none; font-weight: 600" class="text-success mb-3">Customer Reviews</button>
                                            </form>
                                            <h4>Product Description</h4>
                                            <p class="tab">
                                                <?php echo $description; ?>
                                            </p>
                                            <h4>Price</h4>
                                            <p class="tab">
                                                <?php printf("£%0.2f", $price); ?>
                                            </p>
                                            <?php displaySizes($itemID, $sqlConnection); ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
            
            mysqli_close($sqlConnection);
        }
    }
?>


