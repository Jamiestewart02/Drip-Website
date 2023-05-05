    <!-- Sign-in Modal -->
    <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-light" id="signInModalLabel">Sign In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" action="Includes/login.php" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="text" class="email form-control" name="signInEmail" id="email" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="signInPassword" id="password">
                        </div>
                        <div class="modal-footer d-flex justify-content-center row-mb-3">
                            <p class="text-center"><span id="loginerrorMessage"></span></p>
                            <button type="submit" onclick="checkForm('#loginForm', 'loginerrorMessage')" name="signInSubmit" class="btn btn-secondary text-light">Sign In</button>
                            <?php
                                if (isset($_GET["wrongCredentials"])) {
                                    echo "<p class='text-danger text-center'>". $_GET['wrongCredentials']. "</p>";
                                }
                            ?>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <p class="me-auto text-dark">Don't have an account? <a href="registerPage.php">Sign up here</a></p>
                    <button type="submit" name="signInCancel" class="btn btn-secondary text-light" data-bs-dismiss="modal">Close</button>
                    </form>
                <?php
                    if(isset($_GET["errorEmail"]) || isset($_GET["errorPassword"]) || isset($_GET["wrongCredentials"])) {
                        echo '<script>
                                $(document).ready(function(){
                                    $("#signInModal").modal("show");
                                });
                            </script>';
                    }
                ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sign-out Modal -->

    <div class="modal fade" id="signOutModal" tabindex="-1" aria-labelledby="signOutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signOutModalLabel">Sign Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Includes/logout.php" method="post">
                        <div class="mb-3 text-center">
                            <h4>Do You wish to sign out?</h4>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="signOutSubmit" class="btn btn-primary">Sign Out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Modal -->
    
    <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-light" id="accountModalLabel">My Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td class="text-end"><b>Account ID</b></td>
                            <td><?php echo $_SESSION["account"]["AccountID"]; ?></td>
                        </tr>

                        <?php
                            if (isset($_SESSION["account"]["AdminID"])) {
                        ?>

                        <tr>
                            <td class="text-end"><b>Administrator ID</b></td>
                            <td><?php echo $_SESSION["account"]["AdminID"]; ?></td>
                        </tr>

                        <?php
                            }
                        ?>

                        <tr>
                            <td class="text-end"><b>Name</b></td>
                            <td><?php echo $_SESSION["account"]["FirstName"]. " ".$_SESSION["account"]["LastName"]; ?></td>
                        </tr>
                        <tr>
                            <td class="text-end"><b>Address</b></td>
                            <td><?php echo $_SESSION["account"]["Street"]; ?></td>
                        </tr>
                        <tr>
                            <td class="text-end"></td>
                            <td><?php echo $_SESSION["account"]["City"]; ?></td>
                        </tr>
                        <tr>
                            <td class="text-end"></td>
                            <td><?php echo $_SESSION["account"]["Country"]; ?></td>
                        </tr>
                        <tr>
                            <td class="text-end"></td>
                            <td><?php echo $_SESSION["account"]["Postcode"]; ?></td>
                        </tr>
                        <tr>
                            <td class="text-end"><b>E-mail</b></td>
                            <td><?php echo $_SESSION["account"]["Email"]; ?></td>
                        </tr>
                    </table>

                    <div class="row-mb-3 text-center">
                        <button href="#" data-bs-toggle="modal" data-bs-target="#accountEditModal" style="background-color: #008d7d;" class="btn text-light">Edit Account</button>
                        <button href="#" data-bs-toggle="modal" data-bs-target="#passwordChangeModal" style="background-color: rgba(248, 90, 64, 0.8); font-weight: 600" class="btn text-dark">Change Password</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Basket Modal -->
    <div class="modal fade" id="basketModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Your Basket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Basket content goes here -->

                    <?php if (isset($_SESSION["cart"]) && $_SESSION["cartCount"] > 0) { 
                        $total = 0;
                    ?>

                    <table class="table table-striped">

                        <thead>
                            <tr>
                                    <th scope="col"><b>Item</b></th>
                                    <th scopr="col"><b>Quantity</b></th>
                                    <th scope="col">Price</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($_SESSION["cart"] as $key => $value) {
                                    echo "<tr>";
                                    echo (isset($value["Size"])) ? "<td>".$value["Name"]. " <b>(".$value["Size"].")</b></td>" : "<td>".$value["Name"]."</td>";
                                    echo "<td>".$value["Quantity"]."</td>";
                                    printf ("<td>£%0.2f</td>", $value["Price"]);
                                    echo "<td><form action='Includes/removeCartItems.php' method='post'>";
                                    echo "<input type='hidden' name='cartProductID' value='".$value["ProductID"]."'>";
                                    echo (isset($value["Size"])) ? "<input type='hidden' name='cartProductSize' value='".$value["Size"]."'>" : "";
                                    echo "<button type='submit' name='cartDelete' class='btn btn-danger'>Remove</button></form></td>";
                                    echo "</tr>";
                                    $total += $value["Price"];
                                }
                            ?>

                            <tr>
                                <td><b>Total:</b></td>
                                <td><b><?php printf ("£%0.2f", $total); ?></b></td>
                            </tr>

                        </tbody>
                    </table>
                    <?php } else {
                        echo "<p>Your basket is currently empty.</p>";
                    } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                    <a href="checkout.php"><button class="checkout btn btn-secondary">Checkout</button></a>
                </div>
            </div>
        </div>
    </div>

        <!----------- Edit Account Modal ------------->

        <div class="modal fade" id="accountEditModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-light" id="accountEditModalLabel"><?php echo $_SESSION["account"]["AccountID"] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form" id="userEditForm" action="Includes/userAlterAccount.php" method="post">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editFirstName" class="form-label">First Name</label>
                                    <input type="text" oninput="checkLengthFeedback('editFirstName', 'editFirstNameLength', '32')" name="edit[firstName]" class="name small form-control" id="editFirstName" value="<?php echo $_SESSION["account"]["FirstName"] ?>">
                                    <p><span id="editFirstNameLength"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="editLastName" class="form-label">Last Name</label>
                                    <input type="text" name="edit[lastName]" oninput="checkLengthFeedback('editLastName', 'editLastNameLength', '32')" class="name small form-control" id="editLastName" value="<?php echo $_SESSION["account"]["LastName"] ?>">
                                    <p><span id="editLastNameLength"></span></p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="editAddress" class="form-label">Street</label>
                                <input type="text" oninput="checkLengthFeedback('editAddress', 'editAddressLength', '100')" name="edit[street]" class="med form-control" id="editAddress" value="<?php echo $_SESSION["account"]["Street"] ?>">
                                <p><span id="editAddressLength"></span></p>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editCity" class="form-label">City</label>
                                    <input type="text" oninput="checkLengthFeedback('editCity', 'editCityLength', '32')" name="edit[city]" class="small form-control" id="editCity" value="<?php echo $_SESSION["account"]["City"] ?>">
                                    <p><span id="editCityLength"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="editCountry" class="form-label">Country</label>
                                    <select id="editCountry" name="edit[country]" class="form-select">
                                        <option value="England" <?php echo ($_SESSION["account"]["Country"] == "England") ? "selected" : ""; ?>>England</option>
                                        <option value="Scotland" <?php echo ($_SESSION["account"]["Country"] == "Scotland") ? "selected" : ""; ?>>Scotland</option>
                                        <option value="Northern Ireland" <?php echo ($_SESSION["account"]["Country"] == "Northern Ireland") ? "selected" : ""; ?>>Northern Ireland</option>
                                        <option value="Wales" <?php echo ($_SESSION["account"]["Country"] == "Wales") ? "selected" : ""; ?>>Wales</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="editPostcode" class="form-label">Postcode</label>
                                    <input type="text" oninput="checkLengthFeedback('editPostcode', 'editPostcodeLength', '8')" name="edit[postcode]" class="tiny form-control" id="editPostcode" value="<?php echo $_SESSION["account"]["Postcode"] ?>">
                                    <p><span id="editPostcodeLength"></span></p>
                                </div>

                                <div class="col-md-6">
                                    <label for="editEmail" class="form-label">Email</label>
                                    <input type="email" oninput="checkLengthFeedback('editEmail', 'editEmailLength', '100')" name="edit[email]" class="med email form-control" id="editEmail" value="<?php echo $_SESSION["account"]["Email"] ?>">
                                    <p><span id="editEmailLength"></span></p>
                                </div>

                            </div>

                            <div class="row-mb-3 text-center">
                                <input type="hidden" name="edit[id]" value="<?php echo $_SESSION["account"]["AccountID"]; ?>">
                                <button type="submit" onclick="checkForm('#userEditForm', 'userEditError')" style="background-color: #008d7d;" name="<?php echo "edit[submit]"; ?>" class="btn text-light">Save Changes</button>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#userDeleteModal"><button type="submit" style="background-color: rgba(248, 90, 64, 0.8); font-weight: 600" name="<?php echo "edit[delete]"; ?>" class="btn text-dark">Delete Account</button></a>
                            </div>
                            <p id="userEditError" class="text-center"></p>
                            <hr class="hr-splitter">
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!---------------Password Change Modal --------------->

        <div class="modal fade" id="passwordChangeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-light" id="passwordChangeModalLabel">Password Change</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form" id="passwordChangeForm" action="Includes/userAlterAccount.php" method="post">

                            <div class="mb-3">
                                <label for="oldPassword" class="small form-label">To change passwords, please enter your current password</label>
                                <input type="password" name="password[old]" class="form-control" id="changeOldPassword">
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="newPassword" class="small form-label">New Password</label>
                                    <input type="password" oninput="inValidPassword('changeNewPassword', 'changeConfirmPassword', 'changeInValidPasswordMatch', '32')" name="password[new]" class="form-control" id="changeNewPassword">
                                </div>
                                <div class="col-md-6">
                                    <label for="confirmPassword" class="small form-label">Confirm Password</label>
                                    <input type="password" oninput="inValidPassword('changeNewPassword', 'changeConfirmPassword', 'changeInValidPasswordMatch', '32')" name="password[confirm]" class="form-control" id="changeConfirmPassword">
                                </div>
                                <p id="changeInValidPasswordMatch" class="text-center"></p>
                            </div>

                            <div class="row-mb-3 text-center">
                                <input type="hidden" name="password[id]" value="<?php echo $_SESSION["account"]["AccountID"]; ?>">
                                <span id="passwordChangeMessage"></span>
                                <button type="submit" onclick="checkForm('#passwordChangeForm', 'passwordChangeMessage')" style="background-color: #008d7d;" name="password[submit]" class="btn text-light">Save Changes</button>
                            </div>

                            <hr class="hr-splitter">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!--------Modal for New User Creation on Admin Page-------------->

    <div class="modal fade" id="newUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-light" id="newUserModalLabel">Create A New Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form" id="newUser" action="Includes/register.php" method="post">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="newUserFirstName" class="form-label">First Name</label>
                                <input type="text" oninput="checkLengthFeedback('newUserFirstName', 'newUserFirstNameLength', '32')" name="newUser[firstName]" class="name small form-control" id="newUserFirstName">
                                <p><span id="newUserFirstNameLength"></span></p>

                            </div>
                            <div class="col-md-6">
                                <label for="newUserLastName" class="form-label">Last Name</label>
                                <input type="text" oninput="checkLengthFeedback('newUserLastName', 'newUserLastNameLength', '32')" name="newUser[lastName]" class="name small form-control" id="newUserLastName">
                                <p><span id="newUserLastNameLength"></span></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newUserStreet" class="form-label">Street</label>
                            <input type="text" oninput="checkLengthFeedback('newUserStreet', 'newUserStreetLength', '100')" name="newUser[street]" class="med form-control" id="newUserStreet">
                            <p><span id="newUserStreetLength"></span></p>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="newUserCity" class="form-label">City</label>
                                <input type="text" oninput="checkLengthFeedback('newUserCity', 'newUserCityLength', '32')" name="newUser[city]" class="small form-control" id="newUserCity">
                                <p><span id="newUserCityLength"></span></p>
                            </div>
                            <div class="col-md-6">
                                <label for="newUserCountry" class="form-label">Country</label>
                                <select id="newUserCountry" name="newUser[country]" class="form-select">
                                    <option value="England">England</option>
                                    <option value="Scotland">Scotland</option>
                                    <option value="Northern Ireland">Northern Ireland</option>
                                    <option value="Wales">Wales</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <label for="newUserPostcode" class="form-label">Zip</label>
                                <input type="text" oninput="checkLengthFeedback('newUserPostcode', 'newUserPostcodeLength', '8')" name="newUser[postcode]" class="tiny form-control" id="newUserPostcode">
                                <p><span id="newUserPostcodeLength"></span></p>
                            </div>

                            <div class="col-md-6">
                                <label for="newUserEmail" class="form-label">Email</label>
                                <input type="text" oninput="checkLengthFeedback('newUserEmail', 'newUserEmailLength', '100')" name="newUser[email]" class="email med form-control" id="newUserEmail">
                                <p><span id="newUserEmailLength"></span></p>
                            </div>

                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <label for="newUserPassword" class="form-label">Password</label>
                                <input type="password" oninput="inValidPassword('newUserPassword', 'newUserConfirmPassword', 'newUserInValidPasswordMatch', '32')" name="newUser[password]" class="small form-control" id="newUserPassword">
                            </div>

                            <div class="col-md-6">
                                <label for="newUserConfirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" oninput="inValidPassword('newUserPassword', 'newUserConfirmPassword', 'newUserInValidPasswordMatch', '32')" name="newUser[confirmPassword]" class="small form-control" id="newUserConfirmPassword">
                            </div>
                            <p id="newUserInValidPasswordMatch" class="text-center"></p>
                        </div>

                        <div class="row-mb-3 text-center">
                            <p><span id="<?php echo 'newUserError'.$count; ?>"></span></p>
                            <button type="submit" onclick="checkForm('#newUser', 'newUserError')" style="background-color: #008d7d;" name="newUserSubmit" class="btn text-light">Create Account</button>
                            <p class="text-center" id="newUserError"></p>
                        </div>

                        <hr class="hr-splitter">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!--Account deletion protection-->
    <div class="modal fade" id="userDeleteModal" tabindex="-1" aria-labelledby="userDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signOutModalLabel">Sign Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userDeleteForm" action="Includes/userAlterAccount.php" method="post">
                        <div class="mb-3">
                            <label for="editDelete" class="form-label">To delete this account, please enter 'DELETE' in the field below</label>
                            <input type="text" name="edit[delete]" class="delete form-control" id="editDelete">
                        </div>
                        <div class="d-grid">
                            <p id="userDeleteError" class="text-center"></p>
                            <button type="submit" onclick="checkForm('#userDeleteForm', 'userDeleteError')" style="background-color: rgba(248, 90, 64, 0.8); font-weight: 600" name="<?php echo "edit[delete]"; ?>" class="btn text-dark">Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




                            