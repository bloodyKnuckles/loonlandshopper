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

$classifications = array();
if ( isset($_POST['classifications']) && is_array($_POST['classifications']) ) {
  $classifications = $_POST['classifications'];
}

// INCLUDE DB EXECUTE SQL
require($global.$db_access_path);

// UPDATE CLASSIFIED
$sql = "UPDATE Classifieds SET title = '" . addslashes($_POST['title']) . "'";
$sql .= ", description = '" . addslashes($_POST['description']) . "'";
$sql .= ", price = '" . addslashes($_POST['price']) . "'";
$sql .= ", renew_date = '".time()."'";
$sql .= ", approved = 1";
$sql .= " WHERE key_Classifieds = " . $key_Classifieds;
$results = db_execute_sql($sql, "jayblu_ls");

// DELETE CURRENT CLASSIFIEDS_CLASSIFICATIONS
$sql = "DELETE FROM Classifieds_Classifications";
$sql .= " WHERE key_Classifieds = " . $key_Classifieds;
$delete_classifications = db_execute_sql($sql, "jayblu_ls");

// INSERT CLASSIFIEDS_CLASSIFICATIONS
if ( 0 < count($classifications) ) {
  $sql = "INSERT INTO Classifieds_Classifications";
  $sql .= " (";
  $sql .= "key_Classifieds";
  $sql .= ", key_Classifications";
  $sql .= ") VALUES";
  $delimiter = '';
  while ( list($key, $value) = each($classifications) ) {
    $sql .= $delimiter." (".$key_Classifieds.", ".$value.")";
    $delimiter = ",";
  }
  $insert_classifications = db_execute_sql($sql, "jayblu_ls");
}

if ( $results > 0 ) {
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
<title>Loon Land Shopper Update Classified</title>
<meta name="generator" content="BBEdit 6.5" />
<script type="text/javascript" language="Javascript1.1"><!--

parent.opener.location.replace("../index.php");
parent.self.close();

//--></script>
</head>
</html>
<?php

} else {

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
	<title>Loon Land Shopper Update Classified Ad</title>
	<meta name="generator" content="BBEdit 6.5">
</head>
<body>
Sorry, classified information was not updated. Please try again. <?=$results?><br />
<div align="center">
<form>
<input type="button" value="Close" onClick="window.close();" />
</form>
</div>
</body>
</html>
<?php

}

?>
