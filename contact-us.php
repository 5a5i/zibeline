<?php

require("libs/config.php");
$pageDetails = getPageDetailsByName($currentPage);

$your_name = $your_email = $your_subject = $your_message = "";
$your_name_err = $your_email_err = $your_subject_err = $your_message_err = $email_send_suc = $email_send_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["your_name"]))){
        $your_name_err = "Please enter your name.";
    } else {
        $your_name = trim($_POST["your_name"]);
	}

    if(empty(trim($_POST["your_email"]))){
        $your_email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["your_email"]), FILTER_VALIDATE_EMAIL)) {
        $your_email_err = "Invalid email format";
    } else {
        $your_email = trim($_POST["your_email"]);
	}

    if(empty(trim($_POST["your_subject"]))){
        $your_subject_err = "Please enter your subject.";
    } else {
        $your_subject = trim($_POST["your_subject"]);
	}

    if(empty(trim($_POST["your_message"]))){
        $your_message_err = "Please enter your message.";
    } else {
        $your_message = trim($_POST["your_message"]);
	}

    if(empty($your_name_err) && empty($your_email_err) && empty($your_subject_err) && empty($your_message_err)){

		$name = db_prepare_input($_POST["your_name"]);
		$email = db_prepare_input($_POST["your_email"]);
		$subject = db_prepare_input($_POST["your_subject"]);
		$message = db_prepare_input($_POST["your_message"]);
		$message = wordwrap($message, 70, "\r\n");

		$to = "sasi_kumaran@ymail.com";

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type: text/plain; charset=iso-8859-1" . "\r\n";
		$headers .= "From: $name <$email>" . "\r\n";
		$headers .= "X-Mailer: PHP/".phpversion();

		if (mail($to, $subject, $message, $headers)) {
        $email_send_suc = "Your message have been sent successfully.<br>We will reply to you as soon as possible.";
		} else {
        $email_send_err = "Sorry,We're unable to send your message currently.<br>Please try again later.";
		}
	}
}
include("header.php");
?>
<!-- <script type="text/javascript">

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function validateForm() {
	var name = $.trim($("#your_name").val());
	var email = $.trim($("#your_email").val());
	var subject = $.trim($("#your_subject").val());
	var message = $.trim($("#your_message").val());

	if (name == "" ) {
        alert("Enter your name");
		$("#your_name").focus();
        return false;
    }  else if (name.length < 3 ) {
		alert("Enter atleast 2 letter.");
        $("#your_name").focus();
		 return false;
    }

	if (email == "" ) {
        alert("Enter your email");
		$("#your_email").focus();
        return false;
    } else if (!IsEmail(email)) {
        alert("Enter valid email");
		$("#your_email").focus();
        return false;
    }


	if (subject == "" ) {
        alert("Enter your subject");
		$("#your_subject").focus();
        return false;
    }

	if (message == "" ) {
        alert("Enter your message");
		$("#your_message").focus();
        return false;
    }

	return true;
}
</script>
 -->
 <div class="row main-row">
	<div class="8u">
	    <section class="left-content">
	        <h2><?php echo stripslashes($pageDetails["page_title"]); ?></h2>
	        <?php echo stripslashes($pageDetails["page_desc"]); ?>
			<div class="<?php echo (!empty($email_send_suc)) ? 'help-suc' : ''; ?>">
                <?php echo $email_send_suc; ?>
                        </div>
			<div class="<?php echo (!empty($email_send_err)) ? 'help-block' : ''; ?>">
                <?php echo $email_send_err; ?>
                        </div>
	            <div class="container2">
	                <h3><span>Headquarter</span></h3>
                    <div class="row">
                        <div class="col-55-6">
	                <p style="text-align: center;"><strong>Zibeline International Publishing Sdn. Bhd. (1226131-M)<br></strong>(formaformerly known as RAZI Publishing)
	                    <br><i class="Default-pin2"></i>C-3A-15, Centrio Pantai Hillpark,
	                    <br>Jalan Pantai Murni, Pantai Hillpark,
	                    <br>59200, Kuala Lumpur
	                    <br>Malaysia</p>
	                <p style="text-align: center;"><i class="Default-contact"></i>Tel: +60327332657
	                    <br><i class="Default-Fax"></i>Fax: +60327332658</p>
	                <p style="text-align: center;"><i class="Default-mail4"></i>Email: info@zibelinepub.com</p>
                        </div>
                        <!-- <div class="col-55-6">
	                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3983.95063105766!2d101.6637787!3d3.1077628!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4a2beda83d0d%3A0x8532b50a1ee47d74!2sCentrio+Pantai+Hillpark!5e0!3m2!1sen!2smy!4v1513916385341" width="400" height="300" frameborder="0" style="border: 0px; pointer-events: none;" allowfullscreen=""></iframe><br><br>
                        </div> -->
                    </div>
	                <h3><span>Drop Us a Line</span></h3>
	                <label>Whether you’re looking for answers, would like to solve a problem, or just want to let us know how we did, you’ll find many ways to contact us right here</label><br><br>
                    <form action="contact-us.php" method="post" name="f" onsubmit="return validateForm();">
				        <div class="row">
				            <div class="col-25-6">
				                <label class="<?php echo (!empty($your_name_err)) ? 'help-block' : ''; ?>" for="your_name"><span style="color:#F00;">*</span>Name:</label>
				            </div>
				            <div class="col-75-6 <?php echo (!empty($your_name_err)) ? 'has-error' : ''; ?>">
				                <input name="your_name" id="your_name" type="text" class="textbox" value="<?php echo $_SESSION["given_name"]; ?> <?php echo $_SESSION["family_name"]; ?>" autocomplete="off">
                				<span class="help-block"><?php echo $your_name_err; ?></span>
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-25-6">
				                <label class="<?php echo (!empty($your_email_err)) ? 'help-block' : ''; ?>" for="your_email"><span style="color:#F00;">*</span>Email:</label>
				            </div>
				            <div class="col-75-6 <?php echo (!empty($your_email_err)) ? 'has-error' : ''; ?>">
				                <input name="your_email" id="your_email" type="text" class="textbox" value="<?php echo $_SESSION["email"]; ?>" autocomplete="off">
                				<span class="help-block"><?php echo $your_email_err; ?></span>
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-25-6">
				                <label class="<?php echo (!empty($your_subject_err)) ? 'help-block' : ''; ?>" for="your_subject"><span style="color:#F00;">*</span>Subject:</label>
				            </div>
				            <div class="col-75-6 <?php echo (!empty($your_subject_err)) ? 'has-error' : ''; ?>">
				                <input name="your_subject" id="your_subject" type="text" class="textbox" autocomplete="off">
                				<span class="help-block"><?php echo $your_subject_err; ?></span>
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-25-6">
				                <label class="<?php echo (!empty($your_message_err)) ? 'help-block' : ''; ?>" for="your_message"><span style="color:#F00;">*</span>Message:</label>
				            </div>
				            <div class="col-75-6 <?php echo (!empty($your_message_err)) ? 'has-error' : ''; ?>">
				                <textarea class="textarea" name="your_message" id="your_message"></textarea>
                				<span class="help-block"><?php echo $your_message_err; ?></span>
				            </div>
				        </div>
                        <div class="row">
				            <div class="col-25-6">
				            </div>
				            <div class="col-75-6">
                            <input type="submit" value="send" name="sbtn" class="submit_button" />
                        	</div>
                        </div>
                    </form>
	            </div>
	    </section>
	</div>
  <!--sidebar starts-->
  <?php
	include("sidebar.php");
	?>
  <!--sidebar ends-->
</div>
<?php
include("footer.php");
?>
