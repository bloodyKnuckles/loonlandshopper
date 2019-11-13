<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require('db_access_path.php');
require($db_access_path);
$dbname = 'jayblu_ls';

// INCLUDE SEND_MAIL
require("inc/send_mail.php");

$error = '';
$now_date = date("YmdHis");

$classifications = array();
if ( isset($_POST["classifications"]) 
  && is_array($_POST["classifications"])
  && 0 < count($_POST["classifications"])
) { $classifications = $_POST["classifications"]; }
else { $classifications[0] = "3"; } // default Miscellaneous

$key_Classifications_string = '';
$delimiter = '';
while ( list($key, $value) = each($classifications) ) {
  $key_Classifications_string .= $delimiter. db_escape($value, $dbname);
  $delimiter = ',';
}

// GET CLASSIFICATIONS
$sql = "SELECT classification FROM Classifications WHERE key_Classifications IN ($key_Classifications_string)";
$class_info = db_execute_sql($sql, $dbname);

/*/ DEBUG
echo "<pre>";
print_r($class_info);
echo "</pre>";
exit; //*/

$classifications_list = '';
$classifications_string = '';
$delimiter = '';
if ( is_array($class_info) && count($class_info) > 0 ) {
  while ( list($key, $value) = each($class_info) ) {
    $classifications_list .= $value["classification"]."\n";
    $classifications_string .= $delimiter . $value["classification"];
    $delimiter = ',';
  }
}

/*/ DEBUG
echo "<pre>";
print_r($key_Classifieds);
echo "</pre>";
exit; //*/

$ck = ( isset($_COOKIE['cookie_key_Users']) )? db_escape($_COOKIE['cookie_key_Users'], $dbname): 0;
$title = ( isset($_POST['title']) )? db_escape($_POST['title'], $dbname): '';
$description = db_escape($_POST['description'], $dbname);
$classifications_string = db_escape($classifications_string, $dbname);
$price = ( isset($_POST['price']) )? db_escape($_POST['price'], $dbname): '';
$email = db_escape($_POST['email'], $dbname);

// GET USER INFO
if ( 0 < $ck ) {
    list($user_info) = db_execute_sql("SELECT * FROM Users WHERE key_Users = $ck", $dbname);
}
else {
    if ( list($user_info) = db_execute_sql("SELECT * FROM Users WHERE email = '$email'", $dbname) ) {
        $ck = $user_info['key_Users'];
    }
    else {
        $ck = db_execute_sql("INSERT INTO Users (email, uname, create_date) VALUES ('$email', '$email', '$now_date')", $dbname);
    }
    list($user_info) = db_execute_sql("SELECT * FROM Users WHERE key_Users = $ck", $dbname);
}


// INSERT CLASSIFIED
$sql = "INSERT INTO Classifieds";
$sql .= " (";
$sql .= "key_Users";
$sql .= ", title";
$sql .= ", description";
$sql .= ", classifications";
$sql .= ", price";
$sql .= ", renew_date";
$sql .= ", create_date";
$sql .= ", approved";
$sql .= ") VALUES (";
$sql .= $ck;
$sql .= ", '$title'";
$sql .= ", '$description'";
$sql .= ", '$classifications_string'";
$sql .= ", '$price'";
$sql .= ", '".time()."'";
$sql .= ", '".time()."'";
$sql .= ", 0";
$sql .= ")";
$key_Classifieds = db_execute_sql($sql, $dbname);

// MISC
if ( 0 < $key_Classifieds ) {

    /*/ DEBUG
    echo '<pre>';
    print_r($user_info);
    echo '</pre>';
    exit; //*/

    $to = 'info@loonlandshopper.com';
    $from = 'info@loonlandshopper.com';
    $subject = "Your Approval Requested";
    $message = "Sticks,\n\n";
    $message .= "Your approval of a new ad is requested. It is as follows:\n\n";
    $message .= "TITLE:\n";
    $message .= $title."\n\n";
    $message .= "DESCRIPTION:\n";
    $message .= $description."\n\n";
    if ( isset($_FILES["photo"]["name"]) && "" != $_FILES["photo"]["name"] ) {
      $message .= "PHOTO:\n";
      $message .= $_FILES["photo"]["name"]."\n\n";
    }
    $message .= "PRICE:\n";
    $message .= $price."\n\n";
    $message .= "CLASSIFICATIONS:\n";
    $message .= "$classifications_list\n\n";
    $message .= "USER INFO:\n";
    $message .= $user_info["lname"].", ".$user_info["fname"]."\n";
    //$message .= $user_info["city"].", ".$user_info["state"];
    //$message .= " ".$user_info["zip"]."\n";
    $message .= $user_info["email"]."\n";
    $message .= $user_info["phone"]."\n\n";
    $message .= "CLICK TO APPROVE:\n";
    $message .= "http://www.loonlandshopper.com/admin/approve_ad.php";
    $message .= "?key_Classifieds=".$key_Classifieds."\n\n";
    $message .= "CLICK TO EDIT:\n";
    $message .= "http://www.loonlandshopper.com/admin/edit_ad.php";
    $message .= "?key_Classifieds=".$key_Classifieds."\n\n";
    $results = send_mail($to, $from, $subject, $message);


  // INSERT CLASSIFIEDS_CLASSIFICATIONS
  if ( is_array($classifications) ) {
    reset($classifications);
    $sql = "INSERT INTO Classifieds_Classifications";
    $sql .= " (";
    $sql .= "key_Classifieds";
    $sql .= ", key_Classifications";
    $sql .= ") VALUES";
    $delimiter = "";
    while ( list($key, $value) = each($classifications) ) {
      $sql .= $delimiter." (".$key_Classifieds.", ".$value.")";
      $delimiter = ",";
    }
    $insert_classifications = db_execute_sql($sql, $dbname);
  }
} // end misc.

//print '(' . $key_Classifieds . ')' . $error; 

// SUCCESSFUL UPLOAD
if ( 0 < $key_Classifieds && "" == $error ) {
    print '<p>Ad request sent for approval. Thanks for trying us out. Questions? <a href="mailto:info@loonlandshopper.com">info@loonlandshopper.com</a></p>';
}

// ERROR
else { 

?>

Sorry, ad request failed. Please go back and try again. 
<?="Error: ".$error." k: ".$key_Classifieds?>

<?php } ?>
