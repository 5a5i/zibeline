<!DOCTYPE HTML>

<html>

    <head>

        <title><?php echo stripslashes($pageDetails["page_title"]); ?> - <?php echo SITE_NAME; ?></title>

        <link rel="icon" href="images/logo-zibeline.png" type="image/x-icon" />

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <meta name="description" content="<?php echo stripslashes($pageDetails["meta_desc"]); ?>" />

        <meta name="keywords" content="<?php echo stripslashes($pageDetails["meta_keywords"]); ?>" />

        <link href='css/fonts-googleapisUbuntuCondensed.css' rel='stylesheet' type='text/css'>

        <script src="js/jquery.min.js"></script>

        <noscript>

        <link rel="stylesheet" href="css/skel-noscript.css" />

        <link rel="stylesheet" href="css/style.css" />

        <link rel="stylesheet" href="css/style-desktop.css" />

        <link rel="stylesheet" href="css/style-form.css" />

        </noscript>

        <link rel="stylesheet" type="text/css" href="slide/engine1/style.css" />

        <link rel="stylesheet" type="text/css" href="css/style-form.css" />



        <script type="text/javascript" src="slide/engine1/jquery.js"></script>



        <!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->

        <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->

    </head>

    <body>

        <!-- ********************************************************* -->

        <div id="header-wrapper">

            <div class="container">

                <div class="row">

                    <div class="12u">

                        <header id="header">

                            <h1><a href="/zibeline" id="logo"><?php echo SITE_NAME; ?></a></h1>

                            <nav id="nav">

                                <a href="journals.php" <?php echo ($currentPage == "journals") ? ' class="current-page-item"' : '' ?> >Journals</a>

                                <a href="books.php" <?php echo ($currentPage == "books") ? ' class="current-page-item"' : '' ?> >Books</a>

                                <a href="about-us.php" <?php echo ($currentPage == "about-us") ? ' class="current-page-item"' : '' ?> >About Us</a>

                                <a href="contact-us.php" <?php echo ($currentPage == "contact-us") ? ' class="current-page-item"' : '' ?>>Contact US</a>

                                <?php  session_start();

                                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

                                    ?> <a href="accaunt.php" <?php echo ($currentPage == "accaunt") ? ' class="current-page-item"' : '' ?>>Accaunt</a>

                                <?php } else { ?> <a href="login.php" <?php echo ($currentPage == "accaunt") ? ' class="current-page-item"' : '' ?>>Accaunt</a> <?php } ?>

                                <!-- <a href="manage-site" target="_blank">Manage Site</a> -->

                            </nav>

                        </header>



                    </div>

                </div>

            </div>

        </div>

        <?php

        if ($currentPage == "index") {

            try {

                $stmt = $DB->prepare("SELECT * FROM " . TABLE_TAGLINE . " WHERE 1 LIMIT 1");

                $stmt->bindValue(":pname", $pageAlias);

                $stmt->execute();

                $details = $stmt->fetchAll();

            } catch (Exception $ex) {

                echo errorMessage($ex->getMessage());

            }

            ?>

            <div id="banner-wrapper">

                <div class="container">

                    <div class="row">

                        <div class="12u">

                            <div id="banner">

                                <h2><?php echo stripslashes($details[0]["tagline1"]); ?></h2>

                                <span><?php echo stripslashes($details[0]["tagline2"]); ?></span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <?php } ?>

        <div id="main">

            <div class="container">
