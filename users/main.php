<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$global = "../";
require($global.'db_access_path.php');

require($global.$db_access_path);

$now_date = date("Y-m-d");

// GET CLASSIFIEDS
$sql = "SELECT key_Classifieds, title";
$sql .= ", SUBSTRING(description, 1, 50) AS description";
$sql .= ", price, renew_date, approved, Classifieds.active";
$sql .= " FROM Users, Classifieds";
$sql .= " WHERE Users.key_Users = Classifieds.key_Users";
$sql .= " AND uname = '".$_COOKIE['cookie_uname']."'";
$sql .= " AND Classifieds.active = 1";
$classifieds = db_execute_sql($sql, "jayblu_ls");

?>
<!-- JAVASCRIPT -->
<script type="text/javascript" language="JavaScript1.1" 
  src="<?=$global;?>common/window_open.js"></script>
<script type="text/javascript" language="JavaScript1.1"><!--

var w;

function check_form(f) {
  var pass = 0;
<?php

if ( count($classifieds) > 1 ) {

?>
  for ( i = 0; i < f.elements.length; i++ ) {
    if ( f.elements[i].type == "checkbox" && f.elements[i].checked == true) pass = 1;
  }
<?php

} else {

?>
  if ( f.key_Classifieds.checked == true) pass = 1;
<?php

}

?>
  if ( pass == 0 ) alert("No classified ads are selected.");
  return pass;
}

function renew_ads(f) {
  if ( !check_form(f) ) return false;
  var url_str = "common/temp.php";
  var param = "location=no,scrollbars=no,STATUS=no";
  param += ",MENUBAR=no,TOOLBAR=no,RESIZEABLE=no";
  w = window_open(300, 0, 145, 25, url_str, "updateads", param);
  f.mode.value = "renew_ads";
  f.submit(); 
}

function remove_ads(f) {
  if ( !check_form(f) ) return false;
  var url_str = "common/temp.php";
  var param = "location=no,scrollbars=no,STATUS=no";
  param += ",MENUBAR=no,TOOLBAR=no,RESIZEABLE=no";
  w = window_open(300, 0, 145, 25, url_str, "updateads", param);
  f.mode.value = "remove_ads";
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
            <a href="index.php?page=edit_user.php">
            Edit User</a></td>
        </tr>

        <tr>
          <td>
            <a href="index.php?page=details_ad.php&key_Classifieds=0">
            New Ad</a></td>
        </tr>

        <tr>
          <td>
            <a href="index.php" 
              onClick="renew_ads(document.forms[0]); return false">
            Renew Ads</a></td>
        </tr>

        <tr>
          <td>
            <a href="index.php" 
              onClick="remove_ads(document.forms[0]); return false;">
            Remove Ads</a></td>
        </tr>

      </table></td>

    <td valign="top">
      <table border="1">
<form action="common/update_ads.php" method="post" target="updateads">
<input type="Hidden" name="mode" value="" />
<?php

if ( is_array($classifieds) ) {

?>
        <tr>
          <td>
            </td>
          <td>
            <strong>Title</strong></td>
          <td>
            <strong>Description</strong></td>
          <td>
            <strong>Price</strong></td>
          <td>
            <strong>Expires</strong></td>
          <td>
            <strong>Status</strong></td>
        </tr>
<?php

  while ( list($key, $value) = each($classifieds) ) {
    echo "<tr>\n";
    echo "  <td>\n";
    echo "    <input type=\"Checkbox\" name=\"key_Classifieds";
    if ( count($classifieds) > 1 ) echo "[]";
    echo "\" value=\"".$value["key_Classifieds"]."\" /></td>\n";
    echo "  <td>\n";
    echo "    <a href=\"index.php";
    echo "?page=details_ad.php";
    echo "&key_Classifieds=".$value["key_Classifieds"]."\">\n";
    echo "    ".$value["title"]."</a></td>\n";
    echo "  <td style=\"font-size: x-small;\">\n";
    echo "    ".$value["description"]."</td>\n";
    echo "  <td align=\"right\">\n";
    echo "    $".$value["price"]."</td>\n";
    echo "  <td>\n";
    echo "    ";
    $renew_date = date("Y-m-d", mktime(0,0,0, date("m", $value["renew_date"]) + 1, date("d", $value["renew_date"]), date("Y", $value["renew_date"])));
    echo $renew_date;
    echo "</td>\n";
    echo "  <td>\n";
    echo "    ";
    if ( $now_date > $renew_date ) {
      echo "<span style=\"color: red;\">EXPIRED</span>\n";
    }
    else {
      switch ( $value["approved"] ) {
        case 0:
          echo "PENDING";
          break;
        case 1:
          echo "GRANTED";
          break;
      }
    }
    echo "</td>\n";
    echo "</tr>\n";
  }

} else {
  echo "<tr><td>No classifieds found.</td></tr>";
}

?></form></table></td>
  </tr>
</table>
