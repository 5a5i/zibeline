<?php
// Initialize the session
session_start();

 
require("libs/config.php");

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    // Prepare a select statement
    $sql = "SELECT id, user_id, type, code FROM ". TABLE_VALIDATION ." WHERE user_id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $user_id);        
        // Set parameters
        $user_id = $_SESSION["id"];
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $vid, $vuser_id, $vtype, $hashed_code);
                if(mysqli_stmt_fetch($stmt)){
                    session_start();
                    $_SESSION["vid"] = $vid;
                    $_SESSION["hashed_code"] = $hashed_code;
                    $_SESSION["vtype"] = $vtype;
                    if($vtype == 1){
                        $page_desc =  "Welcome and thank you for sign up our website.<br>You haven't validate your accaunt.<br>Please validate your accaunt with the validation code from your E-Mail.";
                        $validation_form = "show";
                        $resend_code = "show";
                    } elseif($vtype == 2) {
                        $page_desc =  "Welcome and thank you for sign up our website.<br>Sorry, we are unable to send validation code to your account for verification.<br>Please click the resend code button to send validation code to your E-Mail.";
                        $resend_code = "show";
                        
                    }
                }
            } else {
            $page_desc =  "Welcome back.<br>Your Profile";
            $user_profile = "show";                 
            }
        } else {
            $page_desc =  "Oops! Something went wrong. Please try again later.";
        }
    mysqli_stmt_close($stmt);
    }
} else {
  header("location: login.php");
  exit;
}

// Define variables and initialize with empty values
$captcha = "";
$code_err = $captcha_err = "";

// Processing form data when form is submitted
if (isset($_POST["validate"])) {
 
    // Check if code is empty
    if(empty(trim($_POST["code"]))){
        $code_err = "Please enter validation code.";
    } elseif(password_verify(trim($_POST["code"]), $_SESSION["hashed_code"])) {
        $vid = $_SESSION["vid"];
        $code = trim($_POST["code"]);
    } else {
        // Display an error message if code is not valid
        $code_err = "The validation code you entered was not valid.";
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
    
    // Validate credentials
    if(empty($code_err) && empty($captcha_err)){
        // Prepare a select statement
        $sql2 = "DELETE FROM ". TABLE_VALIDATION ." WHERE id = ?";
        
        if($stmt2 = mysqli_prepare($link, $sql2)){
            mysqli_stmt_bind_param($stmt2, "s", $param_vid);
            $param_vid = $vid;
            if(mysqli_stmt_execute($stmt2)){
                header("location: accaunt.php");
            } else {
                $page_desc = "Oops! Something went wrong. Please try again later.";
            }
        mysqli_stmt_close($stmt2);  
        }     
    }    
    mysqli_close($link); 
}

if (isset($_POST["resend"])) {
    include_once('rand.php');
    $random = randStrGen(10);
    $param_random = password_hash($random, PASSWORD_DEFAULT);
    $email = $_SESSION["email"];
    $param_vid = $_SESSION["vid"];
    $subject = "Validation code from Zibeline";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Zibeline" . "\r\n";
    $headers .= "X-Mailer: PHP/".phpversion();
    $sqlv = "UPDATE ". TABLE_VALIDATION ." SET type = ? , code = ? WHERE id = ?";

    if(empty($_SESSION["picture"])){
    $message = "Hi ".$_SESSION["given_name"].",<br><br>Welcome and thank you for sign up our website.<br><br>Please copy the following validation code to validate your email with our website:<br><br>".$random."<br><br><i>Note:You haven't upload your picture.</i><br><br>Thank you,<br>Sasi Kumaran";
    } else {  
    $message = "Hi ".$_SESSION["given_name"].",<br><br>Welcome and thank you for sign up our website.<br><br>Please copy the following validation code to validate your email with our website:<br><br>".$random."<br><br>Thank you,<br>Sasi Kumaran";
    }

    if (mail($email, $subject, $message, $headers)){
        if($stmtv = mysqli_prepare($link, $sqlv)){
                $type = 1;
            mysqli_stmt_bind_param($stmtv, "sss", $type, $param_random, $param_vid);
            if(mysqli_stmt_execute($stmtv)){
                $_SESSION = array();
                session_destroy();
                setcookie('cp', 2, time() + 300, '/');
                header("location: login.php");
                exit;
                }
            mysqli_stmt_close($stmtv);
            }
        } else {
            $_SESSION = array();
            session_destroy();
            setcookie('cp', 3, time() + 300, '/');
            header("location: login.php");
            exit;
        }   
mysqli_close($link);
}
$pageDetails = getPageDetailsByName($currentPage);

include("header.php");
?>
<div class="row main-row">
    <div class="8u">
        <section class="left-content">
            <div class="<?php echo ($validation_form == "show") ? 'wrapper' : ''; ?><?php echo ($user_profile == "show") ? 'container2' : ''; ?>">
                <h2><?php echo stripslashes($pageDetails["page_title"]); ?></h2>
                <strong><?php echo $page_desc; ?></strong>
                <div id="validation_form" <?php echo ($validation_form == "show") ? '' : 'style="display:none"'; ?>>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group <?php echo (!empty($code_err)) ? 'has-error' : ''; ?>">
                            <label class="<?php echo (!empty($code_err)) ? 'help-block' : ''; ?>" for="code">Validation code</label>
                            <input type="text" name="code" id="code" class="form-control" value="<?php echo $code; ?>">
                            <span class="help-block"><?php echo $code_err; ?></span><br>
                        </div>
                        <div class="form-group <?php echo (!empty($captcha_err)) ? 'has-error' : ''; ?>">
                            <label class="<?php echo (!empty($captcha_err)) ? 'help-block' : ''; ?>" for="captcha">Anti spam code, Please enter 3 black code</label><br>
                            <img src="captcha/captcha.php" alt="captcha image">
                            <input type="text" name="captcha" id="captcha" class="form-control" value="<?php echo $captcha; ?>">
                            <span class="help-block"><?php echo $captcha_err; ?></span><br>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="validate" class="btn btn-primary" value="     Validate    ">
                        </div>
                    </form>
                </div>                
                <div id="resend_code" <?php echo ($resend_code == "show") ? '' : 'style="display:none"'; ?>>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <input type="submit" name="resend" class="btn btn-primary" value="Resend Code">
                        </div>
                    </form>
                </div>
                <div id="user_profile" <?php echo ($user_profile == "show") ? '' : 'style="display:none"'; ?>><br>
                    <?php if(!empty($_SESSION["picture"])){ ?>
                    <div class="row">
                        <div class="col-25-6">
                        </div>
                        <div class="col-75-6">
                            <img src="<?php echo "images/picture/".stripslashes($_SESSION["picture"]); ?>" width="200px" height="250px">
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-25-6">
                            <label for="title">User Name</label>
                        </div>
                        <div class="col-75-6">
                            <label for="title">: <?php echo $_SESSION["username"]; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25-6">
                            <label for="title">Given Name</label>
                        </div>
                        <div class="col-75-6">
                            <label for="title">: <?php echo $_SESSION["given_name"]; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25-6">
                            <label for="title">Family Name</label>
                        </div>
                        <div class="col-75-6">
                            <label for="title">: <?php echo $_SESSION["family_name"]; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25-6">
                            <label for="title">E-Mail</label>
                        </div>
                        <div class="col-75-6">
                            <label for="title">: <?php echo $_SESSION["email"]; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25-6">
                            <label for="title">Status</label>
                        </div>
                        <div class="col-75-6">
                            <label for="title">: <?php echo ($_SESSION["status"] == "A") ? 'Active' : 'Inactive'; ?></label>
                        </div>
                    </div>
                </div>
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