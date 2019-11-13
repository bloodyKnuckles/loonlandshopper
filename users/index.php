<?php

// SET COMMON SCOPE
$global = "../";
$local = "";

error_reporting(E_ALL);
ini_set('register_globals', 'on');

global $required_files;

// SET DEFAULT PAGE
if ( isset($_GET["page"]) ) $page = $_GET["page"];
else if ( isset($_POST["page"]) ) $page = $_POST["page"];
else if ( !isset($_COOKIE['cookie_uname']) ) $page = 'sign_in_form.php';
else $page = "main.php";
if ( preg_match("/^(\/|\.|(ht|f)tp:\/\/)/",$page) ) die('Page not found.');

// INCLUDE COOKIES
//if ( !isset($required_files["cookie.php"]) ) require($local."common/cookie.php");

// SEND HTTP HEADERS
header("Content-type: text/html");
header("Expires: Sat, 10 Nov 2001 14:00:00 GMT");

// DOCUMENT HEADER TOP
require($global."common/document_header_top.php");

// PAGE TITLE
echo "<title>Loonland Shopper: User Account</title>\n";

// STYLESHEET
echo "<style type=\"text/css\">\n";
require($global."css/ls.css");
echo "</style>\n";

// DOCUMENT HEADER BOTTOM
require($global."common/document_header_bottom.php");

// DOCUMENT BODY TOP
require($global."common/document_body_top.php");

/*/ DEBUG
echo '<pre>';
print_r($_COOKIE);
echo '</pre>';
exit;
//*/


// TOP NAVIGATION
?>

<table border="0" width="590" cellspacing="3" cellpadding="3">
  <tr>
    <td class="footer" align="center">
<?php

if ( is_array($_COOKIE) && isset($_COOKIE["cookie_uname"]) ) {
  require($global."common/document_topnav_signin.php");
}
else { echo "&nbsp;"; }

?>
    </td>
  </tr>
</table>
<?php

// REQUIRE PAGE
require($page);

?><br />

<table border="0" width="590" cellspacing="3" cellpadding="3">
  <tr>
    <td class="footer" align="center">
      <hr />
<?php

// BOTTOM NAVIGATION


?>
    </td>
  </tr>
</table>
<?php

// DOCUMENT BODY BOTTOM
require($global."common/document_body_bottom.php");

?>

