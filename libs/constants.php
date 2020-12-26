<?php


define('HTTP_SERVER', 'http://localhost');

define('SITE_DIR', '/zibeline/');


define('DB_PREFIX', 'mp_');

define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_HOST_USERNAME', 'zibeline');
define('DB_HOST_PASSWORD', 'zibeline');
define('DB_DATABASE', 'zibeline');

define('SITE_NAME', 'zibeline');

define('TABLE_PAGES', DB_PREFIX.'pages');
define('TABLE_TAGLINE', DB_PREFIX.'tagline');
define('TABLE_JOURNAL', DB_PREFIX.'journal');
define('TABLE_USER', 'users');
define('TABLE_VALIDATION', 'validation');



/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_HOST, DB_HOST_USERNAME, DB_HOST_PASSWORD, DB_DATABASE);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

?>