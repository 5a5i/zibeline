<?php

require("libs/config.php");

$msg = '';
if (isset($_POST["sub"])) {


    $id = db_prepare_input($_POST["id"]);
    $title = db_prepare_input($_POST["title"]);
    $eissn = db_prepare_input($_POST["eissn"]);
    $issn = db_prepare_input($_POST["issn"]);
    $publishername = db_prepare_input($_POST["publishername"]);
    $email = db_prepare_input($_POST["email"]);
    $language = db_prepare_input($_POST["language"]);
    $startingyear = db_prepare_input($_POST["startingyear"]);
    $discipline = db_prepare_input($_POST["discipline"]);
    $frequency = db_prepare_input($_POST["frequency"]);
    $website = db_prepare_input($_POST["website"]);
    $countries = db_prepare_input($_POST["countries"]);
    $accessingmethod = db_prepare_input($_POST["accessingmethod"]);
    $licensetype = db_prepare_input($_POST["licensetype"]);
    $description = db_prepare_input($_POST["description"]);

    if ($_FILES["fileToUpload"]["name"] == ""){
         $filename = db_prepare_input($_POST["filename"]);
     } else {

        $filename = db_prepare_input($_FILES["fileToUpload"]["name"]);
         $target_dir = "images/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
                if(isset($_POST["sub"]) && $_FILES["fileToUpload"]["tmp_name"] <> "") {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {
                        $msg2 = successMessage("File is an image - " . $check["mime"] . ".");
                        $uploadOk = 1;
                    } else {
                        $msg2 = errorMessage("File is not an image.");
                        $uploadOk = 0;
                    }
                }
                // Check if file already exists
                if (file_exists($target_file)) {
                    $msg3 = errorMessage("Sorry, file already exists.");
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 2000000) {
                    $msg4 = errorMessage("Sorry, your file is too large.");
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    $msg5 = errorMessage("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $msg6 = errorMessage("Sorry, your file was not uploaded.");
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $msg6 = successMessage("The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.");
                    } else {
                        $msg6 = errorMessage("Sorry, there was an error uploading your file or your file is too large.");
                    }
                }
     }

        if ($title <> "" && $description <> "" ) {

            $sql = "UPDATE " . TABLE_JOURNAL . " SET  `title` =  :title,"
                    . " `filename` = :filename, `eissn` =  :eissn,"
                    . " `issn` = :issn, `publishername` =  :publishername,"
                    . " `email` = :email, `language` =  :language,"
                    . " `startingyear` = :startingyear, `discipline` =  :discipline,"
                    . " `frequency` = :frequency, `website` =  :website,"
                    . " `countries` = :countries, `accessingmethod` =  :accessingmethod,"
                    . " `licensetype` = :licensetype, `description` =  :description"
                    . " WHERE `id` = :pid";
                        
            try {
                    $stmt = $DB->prepare($sql);
                    $stmt->bindValue(":pid", $id);
                    $stmt->bindValue(":title", $title);
                    $stmt->bindValue(":filename", $filename);
                    $stmt->bindValue(":eissn", $eissn);
                    $stmt->bindValue(":issn", $issn);
                    $stmt->bindValue(":publishername", $publishername);
                    $stmt->bindValue(":email", $email);
                    $stmt->bindValue(":language", $language);
                    $stmt->bindValue(":startingyear", $startingyear);
                    $stmt->bindValue(":discipline", $discipline);
                    $stmt->bindValue(":frequency", $frequency);
                    $stmt->bindValue(":website", $website);
                    $stmt->bindValue(":countries", $countries);
                    $stmt->bindValue(":accessingmethod", $accessingmethod);
                    $stmt->bindValue(":licensetype", $licensetype);
                    $stmt->bindValue(":description", $description);
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $msg = successMessage("Journal update successfully");
                }  else if ($stmt->rowCount() == 0) {
                    $msg = successMessage("No changes affected");
                } else {
                    $msg = errorMessage("Failed to update journal");
                }
            } catch (Exception $ex) {
                echo errorMessage($ex->getMessage());
            }
               
            } else {
        $msg = errorMessage("All fields are mandatory");
    }
    }
          
        
    


if (isset($_GET["edit"]) && $_GET["edit"] != "") {
    $pageTitle = "Edit Journal";

    try {
        $stmt = $DB->prepare("SELECT * FROM " . TABLE_JOURNAL . " WHERE `id` = :pid");
        $stmt->bindValue(":pid", intval(db_prepare_input($_GET["edit"])));
        $stmt->execute();
        $details = $stmt->fetchAll();
    } catch (Exception $ex) {
        echo errorMessage($ex->getMessage());
    }
}

$pageDetails = getPageDetailsByName($currentPage);

include("header.php");

?>   
<link rel="stylesheet" type="text/css" href="CLEditor/jquery.cleditor.css" />
<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="CLEditor/jquery.cleditor.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#page_desc").cleditor();
    });
    function changeAlias() {
        var title = $.trim($("#page_title").val());
        title = title.replace(/[^a-zA-Z0-9-]+/g, '-');
        $("#page_alias").val(title.toLowerCase());
    }
</script>
<?php 
echo $msg;
echo $msg2;
echo $msg3;
echo $msg4;
echo $msg5;
echo $msg6;
?>

<div class="row main-row">
    <div class="8u">
        <section class="left-content">
            <h2><?php echo stripslashes($pageDetails["page_title"]); ?></h2>
<div class="container2">      
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id" value="<?php echo $_GET["edit"]; ?>"  />
        <input type="hidden" name="filename" id="filename" value="<?php echo stripslashes($details[0]["filename"]); ?>"  />
        <div class="row">
            <div class="col-25-6">
                <label for="title">Title:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="title" id="title" value="<?php echo stripslashes($details[0]["title"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="fileToUpload">Select image to upload:</label>
            </div>
            <div class="col-75-6">
                <label for="fileToUpload">Current image is <?php echo stripslashes($details[0]["filename"]); ?></label> &nbsp; &nbsp;
                <input type="file" name="fileToUpload" id="fileToUpload" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="eissn">E-ISSN:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="eissn" id="eissn" value="<?php echo stripslashes($details[0]["eissn"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="issn">P-ISSN:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="issn" id="issn" value="<?php echo stripslashes($details[0]["issn"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="publishername">Publisher Name:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="publishername" id="publishername" value="<?php echo stripslashes($details[0]["publishername"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="email">Email:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="email" id="email" value="<?php echo stripslashes($details[0]["email"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="language">Language:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="language" id="language" value="<?php echo stripslashes($details[0]["language"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="startingyear">Starting Year:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="startingyear" id="startingyear" value="<?php echo stripslashes($details[0]["startingyear"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="discipline">Discipline:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="discipline" id="discipline" value="<?php echo stripslashes($details[0]["discipline"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="frequency">Frequency:</label>
            </div>
            <div class="col-75-6">
                <select class="form-control" id="frequency" name="frequency">
                    <option value="Weekly">Weekly</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Quaterly">Quaterly</option>
                    <option value="Semi Annually">Semi Annually</option>
                    <option value="Yearly">Yearly</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="website">Website:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="website" id="website" value="<?php echo stripslashes($details[0]["website"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="countries">Country:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="countries" id="countries" value="<?php echo stripslashes($details[0]["countries"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="accessingmethod">Accessing Method:</label>
            </div>
            <div class="col-75-6">
                <input type="text" name="accessingmethod" id="accessingmethod" value="<?php echo stripslashes($details[0]["accessingmethod"]); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="licensetype">License Type:</label>
            </div>
            <div class="col-75-6">
                <select class="form-control" name="licensetype">
                    <option value="Normal">Normal</option>
                    <option value="Priority">Priority</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
                <label for="description">Description:</label>
            </div>
            <div class="col-75-6">
                <textarea name="description" id="description" autocomplete="off" rows="6"><?php echo stripslashes($details[0]["description"]); ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-25-6">
            </div>
            <div class="col-75-6">
                <input type="submit" name="sub" value="Update">
            </div>
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