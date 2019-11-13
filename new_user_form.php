<?php

$uname = '';
if ( isset($_POST['uname']) ) { $uname = $_POST['uname']; }
else if ( isset($_GET['uname']) ) { $uname = $_GET['uname']; }

$lname = '';
if ( isset($_POST['lname']) ) { $lname = $_POST['lname']; }
else if ( isset($_GET['lname']) ) { $lname = $_GET['lname']; }

$fname = '';
if ( isset($_POST['fname']) ) { $fname = $_POST['fname']; }
else if ( isset($_GET['fname']) ) { $fname = $_GET['fname']; }

$email = '';
if ( isset($_POST['email']) ) { $email = $_POST['email']; }
else if ( isset($_GET['email']) ) { $email = $_GET['email']; }

$phone = '';
if ( isset($_POST['phone']) ) { $phone = $_POST['phone']; }
else if ( isset($_GET['phone']) ) { $phone = $_GET['phone']; }

?>

<!-- JAVASCRIPT -->
<script type="text/javascript" language="JavaScript1.1" 
  src="<?=$global;?>common/window_open.js"></script>
<script type="text/javascript" language="JavaScript1.1"><!--

var w;
function new_user(f) {
  if ( f.uname.value == ""
      || f.lname.value == ""
      || f.fname.value == ""
      || f.email.value == ""
      || f.phone.value == ""
      //|| f.city.value == ""
      //|| f.state.value == ""
      //|| f.zip.value == ""
    ) {
    alert("Please fill out all fields.");
    return false;
  }

  //var pattern = new RegExp("^[^@]+@([a-z0-9-]+\.)+[a-z][a-z]+$");
  //if ( pattern.test(f.email.value) ) ;
  //else { 
  //  alert('Return e-mail address \'' + f.email.value + '\' appears to be invalid.');
  //  return false;
  //}

  //var url_str = "<?=$global;?>common/temp.php";
  //var param = "location=no,scrollbars=no,STATUS=no";
  //param += ",MENUBAR=no,TOOLBAR=no,RESIZEABLE=no";
  //w = window_open(300, 0, 145, 25, url_str, "newuser", param);
  //f.submit();
}


//--></script>


<form action="common/new_user.php" method="post">
<!--  target="newuser"" -->


<table border="0">
  <tr>
    <td valign="top">

<!-- PAGE NAVIGATION -->
      <table border="0" bgcolor="#E0E0E0">

        <!-- tr>
          <td>
            <a href="index.php" 
              onClick="new_user(document.forms[0]); return false">
            Sign Up</a></td>
        </tr -->

        <tr>
          <td>
            <a href="index.php" onClick="history.back(); return false">
            Cancel</a></td>
        </tr>

      </table></td>

    <td valign="top">
      <table border="0">

<!-- WRITE NEW USER FORM -->
<table>

<!-- UNAME -->
  <tr>
    <td align="right" valign="top">
      Username:</td>
    <td>
      <input type="text" name="uname" value="<?=$uname;?>" 
        size="32" maxlength="32" /></td>
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

<?php
/*/
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
//*/
?></table></td>
  </tr>
</table>

<input type="submit" value="Sign Up">

</form>

<script type="text/javascript" language="Javascript1.1"><!--

document.forms[0].uname.focus();

//--></script>
