<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$global = "../";
require($global.'db_access_path.php');

require($global.$db_access_path);

$key_Classifieds = 0;
if ( isset($_POST['key_Classifieds']) && 0 < $_POST['key_Classifieds'] ) {
  $key_Classifieds = addslashes($_POST['key_Classifieds']);
}
else if ( isset($_GET['key_Classifieds']) && 0 < $_GET['key_Classifieds'] ) {
  $key_Classifieds = addslashes($_GET['key_Classifieds']);
}

// GET CLASSIFIED AD
$sql = 'SELECT * FROM Classifieds WHERE key_Classifieds = ' . $key_Classifieds;
$classified_ad = db_execute_sql($sql, "jayblu_ls");
  
// GET CLASSIFICATIONS LINKS
$sql =  'SELECT DISTINCT a.key_Classifications, b.classification';
$sql .= ' FROM Classifieds_Classifications AS a, Classifications AS b';
$sql .= ' WHERE a.key_Classifications = b.key_Classifications';
$sql .= ' AND key_Classifieds = ' . $key_Classifieds;
$class_info = db_execute_sql($sql, "jayblu_ls", 1);

// GET CLASSIFICATIONS
$sql = 'SELECT key_Classifications, classification FROM Classifications';
$classifications = db_execute_sql($sql, "jayblu_ls");

?>
<!-- JAVASCRIPT -->
<script type="text/javascript" language="JavaScript1.1" 
  src="<?=$global;?>common/window_open.js"></script>
<script type="text/javascript" language="JavaScript1.1"><!--

var w;
function update_classified(f) {
  if ( f.title.value == "" ) {
    alert("You must fill in the Title field.");
    return false;
  }
  var url_str = "<?=$global;?>common/temp.php";
  var param = "location=no,scrollbars=no,STATUS=no";
  param += ",MENUBAR=no,TOOLBAR=no,RESIZEABLE=no";
  w = window_open(300, 0, 145, 25, url_str, "updateclassified", param);
  f.submit();
}

//--></script>

<table border="0">
  <tr>
    <td valign="top">

<!-- PAGE NAVIGATION -->
      <table border="0" bgcolor="#E0E0E0">

        <tr>
          <td>
            <a href="index.php" 
              onClick="update_classified(document.forms[0]); return false">
            Save</a></td>
        </tr>

        <tr>
          <td>
            <a href="index.php" onClick="history.back(); return false">
            Cancel</a></td>
        </tr>

      </table></td>

    <td valign="top">
      <table border="0">

<!-- WRITE CLASSIFIED AD FORM -->
<table>
<form action="update_classified.php" method="post" 
  target="updateclassified">
<input type="hidden" name="key_Classifieds" value="<?=$key_Classifieds?>" />

<!-- TITLE -->
  <tr>
    <td align="right" valign="top">
      Title:</td>
    <td>
      <input type="text" name="title" value="<?=$classified_ad[0]["title"]?>" 
        size="32" maxlength="32" /></td>
  </tr>

<!-- DESCRIPTION -->
  <tr>
    <td align="right" valign="top">
      Description:</td>
    <td>
      <textarea name="description" rows="5" 
        cols="50"><?=$classified_ad[0]["description"]?></textarea></td>
  </tr>

<!-- PHOTO -->
<?php

$photo_path = "/usr/www/users/jayblu/loonlandshopper/photos/";
if ( is_file($photo_path . $classified_ad[0]["photos"]) ) {

?>
  <tr>
    <td align="right" valign="top">
      Photo:</td>
    <td><img 
      src="../photos/<?=$classified_ad[0]['photos']?>" /></td>
  </tr>

<?php } ?>

<!-- PRICE -->
  <tr>
    <td align="right" valign="top">
      Price:</td>
    <td>
      <input type="text" name="price" value="<?=$classified_ad[0]["price"]?>" 
        size="32" maxlength="32" /></td>
  </tr>

<!-- CLASSIFICATIONS -->
  <tr>
    <td align="right" valign="top">
      Classifications:</td>
    <td>
      <select name="classifications[]" size="5" multiple>
<?php

  if ( is_array($classifications) ) {
    while ( list($key, $value) = each($classifications) ) {
      echo "        <option value=\"".$value["key_Classifications"]."\"";
      if ( isset($class_info[$value["key_Classifications"]]) ) echo " selected";
      echo ">";
      echo $value["classification"]."</option>\n";
    }
  }

?>
      </select></td>
  </tr>

<?php
?></form></table></td>
  </tr>
</table>

<script type="text/javascript" language="Javascript1.1"><!--

document.forms[0].title.focus();

//--></script>
