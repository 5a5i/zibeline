<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "libs/config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = $captcha = "";
$password_suc = $password_err = $new_password_err = $confirm_password_err = $captcha_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } elseif(password_verify(trim($_POST["password"]), $_SESSION["hashed_password"])) {
        $password = trim($_POST["password"]);
        $password_suc = "The password you entered was valid.";
    } else {
        $password_err = "The password you entered was not valid.";
    }

    // Check if captcha is empty
    if(empty(trim($_POST["captcha"]))){
        $captcha_err = "Please enter anti spam code.";
    } elseif($_SESSION["captcha"]==$_POST["captcha"]) {
        $captcha = trim($_POST["captcha"]);
    } else {
        // Display an error message if captcha is not valid
        $captcha_err = "The anti spam code you entered was not valid.<br>Please enter anti spam code again.";
    } 

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(!empty($password_suc) && empty($new_password_err) && empty($confirm_password_err) && empty($password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $_SESSION = array();
                session_destroy();
                setcookie('cp', 1, time() + 300, '/');
                header("location: login.php");
                exit;
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
$pageDetails = getPageDetailsByName($currentPage);
 
include("header.php");
?>
<div class="row main-row">
    <div class="8u">
        <section class="left-content">
            <div class="wrapper">
                <h2><?php echo stripslashes($pageDetails["page_title"]); ?></h2>
                <?php echo stripslashes($pageDetails["page_desc"]); ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">    
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label class="<?php echo (!empty($password_err)) ? 'help-block' : ''; echo (!empty($password_suc)) ? 'help-suc' : ''; ?>">Old Password</label><br>
                        <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                        <span class="<?php echo (!empty($password_err)) ? 'help-block' : ''; echo (!empty($password_suc)) ? 'help-suc' : ''; ?>"><?php echo $password_err; echo $password_suc; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                        <label class="<?php echo (!empty($new_password_err)) ? 'help-block' : ''; ?>">New Password</label>
                        <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                        <span class="help-block"><?php echo $new_password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <label class="<?php echo (!empty($confirm_password_err)) ? 'help-block' : ''; ?>">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control">
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($captcha_err)) ? 'has-error' : ''; ?>">
                        <label class="<?php echo (!empty($captcha_err)) ? 'help-block' : ''; ?>" for="captcha">Anti spam code, Please enter 3 black code</label><br>
                        <img src="captcha/captcha.php" alt="captcha image">
                        <input type="text" name="captcha" id="captcha" class="form-control" value="<?php echo $captcha; ?>">
                        <span class="help-block"><?php echo $captcha_err; ?></span><br>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Change">
                    </div><br><br>
                    <div class="form-group">
                        <p>Do you really want to change your password? <a href="accaunt.php">Cancel</a>.</p>
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