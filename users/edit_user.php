<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$global = "../";
require($global.'db_access_path.php');

require($global.$db_access_path);

// GET USER INFO
$sql = "SELECT *";
$sql .= " FROM Users";
$sql .= " WHERE key_Users = ".$_COOKIE['cookie_key_Users'];
$user_info = db_execute_sql($sql, "jayblu_ls");
extract($user_info[0]);

?>
<!-- JAVASCRIPT -->
<script type="text/javascript" language="JavaScript1.1" 
  src="<?=$global;?>common/window_open.js"></script>
<script type="text/javascript" language="JavaScript1.1"><!--

var w;
function update_user(f) {
  if ( f.lname.value == ""
      || f.fname.value == ""
      || f.email.value == ""
      || f.phone.value == ""
      || f.city.value == ""
      || f.state.value == ""
      || f.zip.value == ""
    ) {
    alert("All fields are required.");
    return false;
  }
  var url_str = "<?=$global;?>common/temp.php";
  var param = "location=no,scrollbars=no,STATUS=no";
  param += ",MENUBAR=no,TOOLBAR=no,RESIZEABLE=no";
  w = window_open(300, 0, 145, 25, url_str, "updateuser", param);
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
              onClick="update_user(document.forms[0]); return false">
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

<!-- WRITE EDIT USER FORM -->
<table>
<form action="common/update_user.php" method="post" 
  target="updateuser">

<!-- UNAME -->
  <tr>
    <td align="right" valign="top">
      Username:</td>
    <td>
      <?=$uname;?></td>
  </tr>

<!-- LNAME -->
  <tr>
    <td align="right" valign="top">
      Last Name:</td>
    <td>
      <input type="text" name="lname" value="<?=$lname;?>" 
        size="32" maxlength="32" /></td>
  </tr>

<!-- FNAME -->
  <tr>
    <td align="right" valign="top">
      First Name:</td>
    <td>
      <input type="text" name="fname" value="<?=$fname;?>" 
        size="32" maxlength="32" /></td>
  </tr>

<!-- EMAIL -->
  <tr>
    <td align="right" valign="top">
      E-Mail:</td>
    <td>
      <input type="text" name="email" value="<?=$email;?>" 
        size="32" maxlength="32" /></td>
  </tr>

<!-- PHONE	 -->
  <tr>
    <td align="right" valign="top">
      Phone:</td>
    <td>
      <input type="text" name="phone" value="<?=$phone;?>" 
        size="32" maxlength="32" /></td>
  </tr>

<!-- CITY STATE ZIP -->
  <tr>
    <td align="right" valign="top">
      City State Zip:</td>
    <td>
      <input type="text" name="city" value="<?=$city;?>" 
        size="20" maxlength="32" />
      <input type="text" name="state" value="<?=$state;?>" 
        size="3" maxlength="2" />
      <input type="text" name="zip" value="<?=$zip;?>" 
        size="10" maxlength="10" /></td>
  </tr>

<!-- MEMBER SINCE -->
  <tr>
    <td align="right" valign="top">
      Member Since:</td>
    <td>
      <?=date("M d, Y", $create_date);?></td>
  </tr>

<?php
?></form></table></td>
  </tr>
</table>

<script type="text/javascript" language="Javascript1.1"><!--

document.forms[0].lname.focus();

//--></script>
