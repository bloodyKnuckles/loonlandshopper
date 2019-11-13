<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
ini_set('register_globals', 'on');
require('db_access_path.php');

// SET COMMON SCOPE
$global = "";
$local = "";

// SEND HTTP HEADERS
$header_info = "Content-type: text/html\n";
header($header_info);
$header_info = "Expires: ";
$header_info .= "Sat, 10 Nov 2001 14:00:00 GMT";
header($header_info);

// SET DEFAULT PAGE
if ( isset($_GET["page"]) ) $page = $_GET["page"];
else if ( isset($_POST["page"]) ) $page = $_POST["page"];
else $page = "main.php";

// Regex extended by pair support, 6/11/10 to cover "php://input" case
if ( preg_match('!^(/|\.|((ht|f)tp|php)://)!i',$page) ) die('Page not found.');

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

// TOP NAVIGATION
?>
<table border="0" width="590" cellspacing="3" cellpadding="3">
  <tr>
    <td class="footer" align="center">
<?php

require($global."common/document_topnav_signin.php");

?>
    </td>
  </tr>
</table>
<?php

// REQUIRE PAGE
if ( '.pl' == strrchr($page, '.') ) {

  $query_string = '';
  $delimiter = '?';
  if ( 'email_alert_form.pl' == $page ) { 
    if ( isset($_POST['email']) ) { 
      $query_string .= $delimiter . 'email=' . urlencode($_POST['email']); 
      $delimiter = '&';
    }
    if ( isset($_POST['item']) ) { 
      $query_string .= $delimiter . 'item=' . urlencode($_POST['item']); 
      $delimiter = '&';
    }
  }

  //virtual("$page$query_string");
  passthru("/usr/bin/perl /usr/home/jayblu/public_html/loonlandshopper/$page");
}
else { require($page); }

?><br>

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
