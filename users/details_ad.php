<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$global = "../";
require($global.'db_access_path.php');

require($global.$db_access_path);

// GET CLASSIFICATIONS LINKS
$sql = "SELECT DISTINCT a.key_Classifications, b.classification";
$sql .= " FROM Classifieds_Classifications AS a, Classifications AS b";
$sql .= " WHERE a.key_Classifications = b.key_Classifications";
$sql .= " AND key_Classifieds = ".$_GET['key_Classifieds'];
$classified_classifications = db_execute_sql($sql, "jayblu_ls");

/*/ PROCESS CLASSIFIED_CLASSIFICATIONS
if ( is_array($classified_classifications) ) {
  $temp_array = array();
  while ( list($key, $value) = each($classified_classifications) ) {
    $temp_array[$value["key_Classifications"]] = $value["key_Classifications"];
  }
  $classified_classifications = $temp_array;
} //*/

if ( $_GET['key_Classifieds'] > 0 ) {

  /*/ GET CLASSIFIED AD
  $sql = "SELECT *";
  $sql .= " FROM Classifieds";
  $sql .= " WHERE key_Classifieds = ".$_GET['key_Classifieds'];
  $classified_ad = db_execute_sql($sql, "jayblu_ls"); //*/

// GET CLASSIFIED AD
$sql = "SELECT title, description, photos";
$sql .= ", price, renew_date, a.create_date";
$sql .= ", phone, city, state, zip";
$sql .= " FROM Classifieds AS a, Users AS b";
$sql .= " WHERE a.key_Users = b.key_Users";
$sql .= " AND key_Classifieds = ".$_GET['key_Classifieds'];
$classified_ad = db_execute_sql($sql, "jayblu_ls");

?>

<style type="text/css" media="all">
<!--

.label {
	font-size: 10px;
	color: gray;
}

-->
</style>


<table border="0">
  <tr>
    <td valign="top" colspan="2"><img src="images/spacer.gif" alt="" width="400" height="1"></td>
  </tr>

  <tr>
    <td valign="top">

<!-- PAGE NAVIGATION -->
      <table border="0" bgcolor="#E0E0E0">

        <tr>
          <td>
            <a href="index.php" onClick="history.back(); return false">
            Back</a></td>
        </tr>

      </table></td>

    <td valign="top">
      <table border="0">

<!-- WRITE CLASSIFIED AD TABLE -->
<table border="0">

<!-- TITLE -->
  <tr>
    <td align="right" valign="top" class="label">
      Title:</td>
    <td>
      <?=$classified_ad[0]["title"]?></td>
  </tr>

<!-- DESCRIPTION -->
  <tr>
    <td align="right" valign="top" class="label">
      Description:</td>
    <td>
      <?=$classified_ad[0]["description"]?></td>
  </tr>

<!-- PHOTOS -->
<?php

$photo_path = "/usr/www/users/jayblu/loonlandshopper/photos/";
if ( is_file($photo_path . $classified_ad[0]["photos"])) {

?>

 <tr>
    <td align="right" valign="top" class="label">
      Photo:</td>
    <td><img style="border: solid 1px silver;"
      src="../photos/<?=$classified_ad[0]['photos']?>" /></td>
  </tr>

<?php

}

?>

<!-- PRICE -->
  <tr>
    <td align="right" valign="top" class="label">
      Price:</td>
    <td>
      <?=$classified_ad[0]["price"]?></td>
  </tr>

<!-- PHONE -->
  <tr>
    <td align="right" valign="top" class="label">
      Phone:</td>
    <td>
      <?=$classified_ad[0]["phone"]?></td>
  </tr>

<!-- CLASSIFICATIONS -->
  <tr>
    <td align="right" valign="top" class="label">
      Classifications:</td>
    <td>
<?php

  if ( is_array($classified_classifications) ) {
    while ( list($key, $value) = each($classified_classifications) ) {
      echo $value["classification"]."<br />";
    }
  }

?></td>
  </tr>

</table></td>
  </tr>
</table>
<?php

} 

else {

?>
<!-- JAVASCRIPT -->
<script type="text/javascript" language="JavaScript1.1" 
  src="<?=$global;?>common/window_open.js"></script>
<script type="text/javascript" language="JavaScript1.1"><!--

var w;
function update_classified(f) {
  var required_elements = 1;
  var fields_list = "";
  var message = "";

  if ( f.title.value == "" ) {
    required_elements = 0;
    fields_list += "Title Field\n";
  }
  if ( f.elements[4].selectedIndex == -1 ) {
    required_elements = 0;
    fields_list += "Classifications List\n";
  }
  if ( required_elements == 0 ) {
    message = "You must enter the following fields:\n\n";
    message += fields_list;
    alert(message);
    return false;
  }
  var url_str = "<?=$global;?>common/temp.php";
  var param = "location=no,scrollbars=no,STATUS=no";
  param += ",MENUBAR=no,TOOLBAR=no,RESIZEABLE=no";
  w = window_open(300, 0, 145, 25, url_str, "updateclassified", param);
  f.submit();
  return true;
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
            Save Ad</a></td>
        </tr>

        <tr>
          <td>
            <a href="index.php" onClick="history.back(); return false">
            Cancel</a></td>
        </tr>

      </table></td>

    <td valign="top">
      <table border="0">
<?php

  // GET CLASSIFICATIONS
  $sql = "SELECT key_Classifications, classification";
  $sql .= " FROM Classifications";
  $sql .= " ORDER BY display_order";
  $classifications = db_execute_sql($sql, "jayblu_ls");

?>
<!-- WRITE CLASSIFIED AD FORM -->
<table>

<form action="common/update_classified.php" method="post" 
  target="updateclassified" enctype="multipart/form-data"
  onSubmit="update_classified(document.forms[0]);">
<input type="Hidden" name="key_Classifieds" value="0" />
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />

<!-- TITLE -->
  <tr>
    <td align="right" valign="top" class="label">
      Title:</td>
    <td>
      <input type="text" name="title" value="" 
        size="32" maxlength="32" /></td>
  </tr>

<!-- DESCRIPTION -->
  <tr>
    <td align="right" valign="top" class="label">
      Description:</td>
    <td>
      <textarea name="description" rows="5" 
        cols="50"></textarea></td>
  </tr>

<!-- PRICE -->
  <tr>
    <td align="right" valign="top" class="label">
      Price:</td>
    <td>
      $<input type="text" name="price" value="" 
        size="31" maxlength="32" /></td>
  </tr>

<!-- CLASSIFICATIONS -->
  <tr>
    <td align="right" valign="top" class="label">
      Classifications:</td>
    <td>
      <select name="classifications[]" size="5" multiple>
<?php

  if ( is_array($classifications) ) {
    while ( list($key, $value) = each($classifications) ) {
      echo "        <option value=\"".$value["key_Classifications"]."\"";
      echo ">";
      echo $value["classification"]."</option>\n";
    }
  }

?>
      </select></td>
  </tr>

<!-- PHOTO -->
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="top" class="label">
      Photo:</td>
    <td>
      <input type="file" name="photo" accept="image/jpeg" />
    </td>
  </tr>

  <tr>
    <td>&nbsp;</td>
  </tr>


</form></table></td>
  </tr>
</table>

<table>
  <tr>
    <td>

      <p style="font-size: small; color: gray;">Add a photo. Only $10 until sold.<br>
      Send check to: Loonland Shopper, PO Box 33, Virginia, Minn. 55792</p>

<p style="font-size: small; color: gray;">OR make a PayPal payment:<br>
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
    <input type="hidden" name="cmd" value="_s-xclick"> 
    <input type="hidden" name="hosted_button_id" value="K3ZC7D4F5F9NN"> 
    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" 
      name="submit" alt="PayPal - The safer, easier way to pay online!"> 
    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"> 
  </form> 
</p>

    </td>
  </tr>

  <tr>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td style="font-size: small; color: gray;">Allow up to 12 hours for posting.</td>
  </tr>

</table>


<script type="text/javascript" language="Javascript1.1"><!--

document.forms[0].title.focus();

//--></script>
<?php

}

?>
