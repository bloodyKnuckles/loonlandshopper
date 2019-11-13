<?php

$pass = 0;

// RENEW COOKIES
if ( isset($HTTP_COOKIE_VARS["cookie_uname"]) ) {

  // SET PASS
  $pass = 1;

  // RESET COOKIES
  setcookie(
      "cookie_uname"
      , $_COOKIE['cookie_uname']
//      , time() + 900
    );
  setcookie(
      "cookie_key_Users"
      , $_COOKIE['cookie_key_Users']
//      , time() + 900
    );

}
else { $pass = 0; }

if ( $pass == 0 ) {
  $page_return = $page;
  $page = "sign_in_form.php";
}

// SET REQUIRED FILES
$required_files["cookie.php"] = 1;

?>
