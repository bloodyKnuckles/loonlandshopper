<!-- JAVASCRIPT -->
<script type="text/javascript" language="JavaScript1.1" 
  src="<?=$global;?>common/window_open.js"></script>
<script type="text/javascript" language="JavaScript1.1"><!--

var w;
function sign_in(f) {
  if ( f.sign_in_uname.value == "" ) {
    alert("You must fill in the Username field.");
    return false;
  }
  if ( f.sign_in_pword.value == "" ) {
    alert("You must fill in the Password field.");
    return false;
  }
  var url_str = "<?=$global;?>common/temp.php";
  var param = "location=no,scrollbars=no,STATUS=no";
  param += ",MENUBAR=no,TOOLBAR=no,RESIZEABLE=no";
  w = window_open(300, 0, 145, 25, url_str, "signinwindow", param);
  return true;
}

//--></script>

<table border="0">
  <tr>
    <td rowspan="8">&nbsp;&nbsp;&nbsp;</td>
  </tr>
  
<form action="sign_in.php" method="post" 
  target="signinwindow" onSubmit="return sign_in(this);">
<input type="hidden" name="page_return" value="<?=$page_return;?>">
<input type="hidden" name="mode" value="verify">

  <!-- FORM HEADER -->
  <tr>
    <td class="header">
     Please Sign In</td>
  </tr>
     
  <!-- USERNAME -->
  <tr>
    <td class="label">
      Username:<br />
      <input type="text" name="sign_in_uname" 
        size="30" maxlength="64" /><td>
  </tr>
        
  <!-- PASSWORD -->
  <tr>
    <td class="label">
      PIN:<br />
      <input type="password" name="sign_in_pword"
        size="30" maxlength="64" /><td>
  </tr>

  <!-- SPACER -->
  <tr>
   <td class="label">
      &nbsp;<td>
  </tr>

  <!-- SIGN IN BUTTON -->
  <tr>
    <td>
      <input type="submit" name="sign_in_button" 
        value="Sign In"><td>
  </tr>

</form>

  <!-- SPACER -->
  <tr>
   <td class="label">
      &nbsp;<td>
  </tr>

  <tr>
    <td>
      Don't have an account with us?
      <a href="<?=$global;?>index.php?page=new_user_form.php&page_return=<?=$page_return;?>">
      Sign up!</a><br />
      Lost your PIN?
      <a href="<?=$global;?>index.php?page=email_pword_form.php">
      Request a new one.</a>.</td>
  </tr>
</table>

<script type="text/javascript" language="Javascript1.1"><!--

document.forms[0].sign_in_uname.focus();

//--></script>
