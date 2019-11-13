<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$global = "../";
require($global.'db_access_path.php');

$key_Classifieds = 0;
if ( isset($_POST['key_Classifieds']) && 0 < $_POST['key_Classifieds'] ) {
  $key_Classifieds = addslashes($_POST['key_Classifieds']);
}
else if ( isset($_GET['key_Classifieds']) && 0 < $_GET['key_Classifieds'] ) {
  $key_Classifieds = addslashes($_GET['key_Classifieds']);
}


// INCLUDE DB EXECUTE SQL
require($global.$db_access_path);

// INCLUDE DB SENDMAIL
require($global."inc/send_mail.php");

// UPDATE CLASSIFIED
$sql = 'UPDATE Classifieds SET approved = 1 WHERE key_Classifieds = ' . addslashes($key_Classifieds);
$results = db_execute_sql($sql, "jayblu_ls");

// GET CLASSIFIED AD
$sql = 'SELECT title, email FROM Classifieds INNER JOIN Users USING (key_Users)';
$sql .= ' WHERE key_Classifieds = ' . addslashes($key_Classifieds);
list($ad_info_db) = db_execute_sql($sql, "jayblu_ls");

$title = $ad_info_db['title'];
$to = $ad_info_db['email'];
$from = "customerservice@loonlandshopper.com";
$subject = "Loon Land Shopper Ad Approved";
$message = "Hey! Your Loon Land Shopper ad, $title, was approved. (Big thanks!)";
$results = send_mail($to, $from, $subject, $message);

?>
<a href="../">Classifications</a><br />
How's that?
