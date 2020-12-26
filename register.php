<?php

require("libs/config.php");

// Define variables and initialize with empty values
$username = $password = $email = $picture = $given_name = $family_name = $confirm_password = "";
$username_err = $password_err = $email_err = $picture_err = $given_name_err = $family_name_err = $picture_suc = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    } 

    if (empty($_POST["given_name"])) {
        $given_name_err = "Please enter your given name.";
    // check if name only contains letters and whitespace
    } elseif (!preg_match("/^[a-zA-Z ]*$/",$_POST["given_name"])) {
        $given_name_err = "Only letters and white space allowed"; 
    } else {
        $given_name = trim($_POST["given_name"]);
    }

    if (empty($_POST["family_name"])) {
        $family_name_err = "Please enter your family name.";
    // check if name only contains letters and whitespace
    } elseif (!preg_match("/^[a-zA-Z ]*$/",$_POST["family_name"])) {
        $family_name_err = "Only letters and white space allowed"; 
    } else {
        $family_name = trim($_POST["family_name"]);
    }


    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else {
        $email_val = trim($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email_val, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format"; 
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already registered.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
}
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    

        $target_dir = "images/picture/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if there is any file was selected
    if($_FILES["picture"]["tmp_name"] <> "") {
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if($check == false) {
            $picture_err = "File is not an image.";
        } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $picture_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } elseif (file_exists($target_file)) {
            $picture_err = "Sorry, file already exists.";
        } else {
            if ($_FILES["picture"]["size"] > 2000000) {
                $picture_err = "Sorry, your file is too large.";
            } else {
                $picture = basename($_FILES["picture"]["name"]);
            }
        }
    }

            // Set parameters
            include_once('rand.php');
            $random = randStrGen(10);
            $param_random = password_hash($random, PASSWORD_DEFAULT);
            $status = "A";            
            $date = date("Y-m-d H:i:s");
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $subject = "Validation code from Zibeline";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: Zibeline" . "\r\n";
            $headers .= "X-Mailer: PHP/".phpversion();

            $sql = "INSERT INTO ". TABLE_USER ." (username, password, email, family_name, given_name, picture, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $sqlv = "INSERT INTO ". TABLE_VALIDATION ." (user_id, type, code) VALUES (?, ?, ?)";             

            if(empty($picture)){
            $message = "Hi ".$given_name.",<br><br>Welcome and thank you for sign up our website.<br><br>Please copy the following validation code to validate your email with our website:<br><br>".$random."<br><br><i>Note:You haven't upload your picture.</i><br><br>Thank you,<br>Sasi Kumaran";
            $param_picture = null;
            } else {            
                if(move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                    $message = "Hi ".$given_name.",<br><br>Welcome and thank you for sign up our website.<br><br>Please copy the following validation code to validate your email with our website:<br><br>".$random."<br><br>Thank you,<br>Sasi Kumaran";
                    $param_picture = $picture;
                } else {
                    $message = "Hi ".$given_name.",<br><br>Welcome and thank you for sign up our website.<br><br>Please copy the following validation code to validate your email with our website:<br><br>".$random."<br><br><i>Note:Sorry, we are unable to upload your picture.</i><br><br>Thank you,<br>Sasi Kumaran";
                    $param_picture = null;
                }
            }

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($picture_err)){
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssssss", $username, $param_password, $email, $family_name, $given_name, $param_picture, $status, $date);
            if(mysqli_stmt_execute($stmt)){
                $last_id = mysqli_insert_id($link);
                if($stmtv = mysqli_prepare($link, $sqlv)){
                    if (mail($email, $subject, $message, $headers)){
                            $type = 1;
                        mysqli_stmt_bind_param($stmtv, "sss", $last_id, $type, $param_random);
                        if(mysqli_stmt_execute($stmtv)){
                            session_start();
                            $_SESSION["ve"] = $type;
                            header("location: login.php");
                        }
                    mysqli_stmt_close($stmtv);
                    } else {
                        $type = 2;
                        mysqli_stmt_bind_param($stmtv, "sss", $last_id, $type, $param_random);
                        if(mysqli_stmt_execute($stmtv)){
                            session_start();
                            $_SESSION["ve"] = $type;
                            header("location: login.php");
                        }
                    }
                }
                    mysqli_stmt_close($stmtv);
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
    mysqli_stmt_close($stmt);
    }
mysqli_close($link);
}

require("libs/config.php");
$pageDetails = getPageDetailsByName($currentPage);

include("header.php");
?>
<div class="row main-row">
    <div class="8u">
        <section class="left-content">
    <div class="wrapper">
                <h2><?php echo stripslashes($pageDetails["page_title"]); ?></h2>
                <?php echo stripslashes($pageDetails["page_desc"]); ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label class="<?php echo (!empty($username_err)) ? 'help-block' : ''; ?>">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label class="<?php echo (!empty($password_err)) ? 'help-block' : ''; ?>">Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label class="<?php echo (!empty($confirm_password_err)) ? 'help-block' : ''; ?>">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label class="<?php echo (!empty($email_err)) ? 'help-block' : ''; ?>">E-Mail</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($picture_err)) ? 'has-error' : ''; ?>">
                <label class="<?php echo (!empty($picture_err)) ? 'help-block' : ''; ?>">Picture</label><br>
                <input type="file" name="picture" id="picture" class="form-control" value="<?php echo $picture; ?>"><br>
                <span class="help-block"><?php echo $picture_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($given_name_err)) ? 'has-error' : ''; ?>">
                <label class="<?php echo (!empty($given_name_err)) ? 'help-block' : ''; ?>">Given Name</label>
                <input type="text" name="given_name" class="form-control" value="<?php echo $given_name; ?>">
                <span class="help-block"><?php echo $given_name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($family_name_err)) ? 'has-error' : ''; ?>">
                <label class="<?php echo (!empty($family_name_err)) ? 'help-block' : ''; ?>">Family Name</label>
                <input type="text" name="family_name" class="form-control" value="<?php echo $family_name; ?>">
                <span class="help-block"><?php echo $family_name_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" name="sub" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <div class="form-group">
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </div>
        </form>
    </div> 
        </section>    
    </div>
    <!--sidebar starts-->
    <?php include("sidebar.php"); ?>    
    <!--sidebar ends-->
</div>
<?php
include("footer.php");
?>