<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$global = "../";
require($global.'db_access_path.php');

require($global.$db_access_path);

// CHECK DATABASE
$sql = "SELECT key_Users, uname FROM Users";
$sql .= " WHERE uname = '" . addslashes($_POST['sign_in_uname']) . "'";
$sql .= " AND pword = OLD_PASSWORD('".addslashes($_POST['sign_in_pword']) . "')";
$sql .= " AND active = 1";
$results = db_execute_sql($sql, "jayblu_ls");

if ( is_array($results) && count($results) > 0 ) {

 // SET COOKIES
  $time_out = time() + 900;
  setcookie(
    "cookie_uname"
    , $results[0]["uname"]
//    , $time_out
//    , '/'
  );
  setcookie(
    "cookie_key_Users"
    , $results[0]["key_Users"]
//    , $time_out
//    , '/'
  ); //*/

$required_files['cookie.php'] = 1;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
<title>Loon Land Shopper Sign In</title>
<meta name="generator" content="BBEdit 6.5" />
<script type="text/javascript" language="Javascript1.1"><!--

parent.opener.location.reload();
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
	<title>Loon Land Shopper Sign In</title>
	<meta name="generator" content="BBEdit 6.5">
</head>
<body>
Sorry, username or password not found.<br />
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
