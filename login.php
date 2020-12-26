<?php
// Initialize the session
session_start();
 
require("libs/config.php");

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: accaunt.php");
  exit;
}

$pageDetails = getPageDetailsByName($currentPage);
if($_SESSION["ve"] == 2){
    $page_desc = "Thank you for sign up our website.<br><div class='help-block'>We regret to inform you that we are unable to send validation code to your account for verification.<br>Please login again and click the resend validation code button.</div>";
} elseif($_SESSION["ve"] == 1){
    $page_desc = "Thank you for sign up our website and we have sent an E-Mail with validation code to your accaunt for verification.<br>Please check your E-Mail and login back with validation code to validate your accaunt.";
} elseif($_COOKIE["cp"] == 2){
    $page_desc = "We have resent an E-Mail with validation code to your accaunt for verification.<br>Please check your E-Mail and login back with validation code to validate your accaunt.";
} elseif($_COOKIE["cp"] == 3){
    $page_desc = "Sorry, We are unable to send E-Mail at the moment.<br>Please try again later.";
} elseif($_COOKIE["cp"] == 1){
    $page_desc = "You have successfully changed your password.<br>Please login back with your new password.";
} else {
    $page_desc = stripslashes($pageDetails["page_desc"]);
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password, status, picture, given_name, family_name, email FROM ".TABLE_USER." WHERE username = ?";    
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $status, $picture, $given_name, $family_name, $email);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION["loggedin"] = true;     
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;
                            $_SESSION["hashed_password"] = $hashed_password;
                            $_SESSION["status"] = $status;                
                            $_SESSION["picture"] = $picture;
                            $_SESSION["given_name"] = $given_name;
                            $_SESSION["family_name"] = $family_name;
                            unset($_COOKIE['cp']);
                            setcookie('cp', '', time() -1, '/');
                            header("location: accaunt.php");
                        } else{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $username_err = "No account found with that username.";
                }
            } else{
                $username_err = "Oops! Something went wrong. Please try again later.";
            }        
        // Close statement
        mysqli_stmt_close($stmt);
        }    
    // Close connection
    mysqli_close($link);
    }
}

include("header.php");
?>
<div class="row main-row">
    <div class="8u">
        <section class="left-content">
            <div class="wrapper">
                <h2><?php echo stripslashes($pageDetails["page_title"]); ?></h2>
                <?php echo $page_desc; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label class="<?php echo (!empty($username_err)) ? 'help-block' : ''; ?>">Username<?php echo $_SESSION["loggedin"]; ?></label>
                        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span><br>
                    </div>    
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label class="<?php echo (!empty($password_err)) ? 'help-block' : ''; ?>">Password</label><br>
                        <input type="password" name="password" class="form-control"><br>
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div><br><br>
                    <div class="form-group">
                    <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
                    <p>Forgot password? <a href="reset.php">Reset</a>.</p>
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