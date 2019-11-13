<?php

require($global.$db_access_path);

// GET CLASSIFICATIONS
$sql = "SELECT *";
$sql .= " FROM Classifications";
$sql .= " ORDER BY display_order";
$classifications = db_execute_sql($sql, "jayblu_ls");
//echo $sql."<br />\n";

// GET AD COUNTS
$sql = "SELECT a.key_Classifications, COUNT(*) AS c";
$sql .= " FROM Classifieds_Classifications AS a";
$sql .= ", Classifieds AS b";
$sql .= " WHERE a.key_Classifieds = b.key_Classifieds";
$sql .= " AND b.active = 1";
$sql .= " AND b.approved = 1";
$sql .= " AND b.renew_date >= ".mktime(23, 1, 59, date("m") - 2, date("d"), date("Y")); // TWO MONTHS OLD
$sql .= " GROUP BY a.key_Classifications";
$ad_counts = db_execute_sql($sql, "jayblu_ls", 1);
//echo $sql."<br />\n";

// GET RANDOM AD
$sql = "SELECT";
$sql .= " key_Classifieds";
$sql .= ", title";
$sql .= ", description";
$sql .= " FROM Classifieds";
$sql .= " WHERE active = 1";
$sql .= " AND approved = 1";
$sql .= " AND renew_date >= ".mktime(23,1,59,date("m") - 2, date("d"), date("Y"));
$sql .= " AND key_Classifieds NOT IN (34, 58)";
$sql .= " ORDER BY RAND() LIMIT 3";
$featured_ads = db_execute_sql($sql, "jayblu_ls");
//echo $sql."<br />\n";

/*/ DEBUG
echo "query: <pre>\n";
print_r($featured_ads);
echo "</pre>\n";
exit; //*/

foreach ( $classifications as $key1 => $value1 ) {
  if ( isset($ad_counts[$value1["key_Classifications"]]["c"]) ) 
    $classifications[$key1]["c"] = $ad_counts[$value1["key_Classifications"]]["c"];
  else $classifications[$key1]["c"] = "0";
}

?>
<table border="0" width="590">
  <tr>
    <td valign="top">

<!-- PAGE NAVIGATION -->
<?php

require("common/navigation.php");

?></td>

    <td valign="top">
      <table border="0">
<?php

foreach( $classifications as $value1 ) {
  echo "<tr>\n";
  echo "  <td>\n";
  echo "  <a href=\"index.php";
  echo "?page=list_ads.php";
  echo "&key_Classifications=".$value1["key_Classifications"];
  echo "\">\n";
  echo "    ".$value1["classification"]."</a>";
  echo " <span style=\"font-size: x-small;\">".$value1["c"]." ad";
  if ( "1" != $value1["c"] ) echo "s";
  echo "</span>";
  echo "</td>\n";
  echo "</tr>\n";
}

?></table></td>

    <td>&nbsp;</td>
    <td valign="top">&#8226; Text ads are FREE!<br>&#8230;add a photo, 10 bucks 'til sold!

<br><br>
<div width="100%" align="center">

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="K3ZC7D4F5F9NN">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" 
name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" 
height="1">
</form>

</div>

<?php

if ( is_array($featured_ads) && 0 < count($featured_ads) ) {

?>

<p>
<table width="200" cellspacing="0" cellpadding="4" align="center"
 border="1" style="border: 1px solid silver;">
  <tr>
    <td style="color: white;" bgcolor="#669966">Featured Ads</td>
  </tr>
<?php


  foreach ( $featured_ads as $value1 ) {
    $title = ( '' != $value1['title'] )? $value1['title']: substr($value1['description'], 0, 20) . '...';
    echo "  <tr>\n";
    echo "    <td>\n";

    echo "<a href=\"index.php?page=details_ad.php&key_Classifieds=";
    echo $value1["key_Classifieds"];
    echo "\">";
    echo $title;

    echo "  </a></td>\n";
    echo "  </tr>\n";
  }


?>
</table>
</p>

<?php } ?>

<script type="text/javascript" language="javascript1.1">
<!--

function validate(form_id,email) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var address = document.forms[form_id].elements[email].value;
   if(reg.test(address) == false) {
      alert('Invalid E-Mail Address');
      return false;
   }
   return true;
}

//-->
</script>

<form id="emailalert" name="emailalert" action="email_alert_process.cgi" method="post" onSubmit="return validate('emailalert','email');">
<input type="hidden" name="page" value="email_alert_form.pl">

<p>
<table width="200" cellspacing="0" cellpadding="4" align="center"
 border="0">
  <tr>
    <td style="font-size: x-small;">Looking for something? Allow us to notify you when it gets posted. Save 
your e-mail alert below.</td>
  </tr>
</table>
<table width="200" cellspacing="0" 
cellpadding="4" align="center"
 border="1" style="border: 1px solid silver;">
  <tr>
    <td style="color: white;" bgcolor="#669966">E-Mail Alert</td>
  </tr>
  <tr>
    <td>

<table width="100%" cellspacing="0" cellpadding="4" border="0">
  <tr>
    <td align="right">E-Mail: <input type="text" name="email" value="" size="15"></td>
  </tr>
  <tr>
    <td align="right">Items: <input type="text" name="item" value="" size="15"><br>
    <span style="font-size: x-small; color: #666666;">Separate items by comma;<br>e.g., <em>boat, stove, bed</em></span></td>
  </tr>
  <tr>
    <td><input type="submit" value="Save Alert"><br>
    <span style="font-size: x-small; color: #666666;"><input type="button" onClick="document.forms.emailalert.action='index.php'; document.forms.emailalert.submit();" value="Expanded Alert Form >"></span></td>
  </tr>
</table>


    </td>
  </tr>
</table>
</p>
</form>

    </td>
  </tr>

    <tr>
        <td colspan="4">

<form id="quick_ad" name="emailalert" action="index.php" method="post" onSubmit="return validate('quick_ad','email');">
    <input type="hidden" name="page" value="quick_ad.php">

<p>
<table width="100%" cellspacing="0" cellpadding="4" align="center"
 border="0">
  <tr>
    <td style="font-size: small;">Want a trial run? Use the Quick Ad form below to send a "no signup" ad to the moderator for approval. When you want to add photos, edit and relist your ads, sign up for an account!</td>
  </tr>
</table>
<table width="100%" cellspacing="0" 
cellpadding="4" align="center"
 border="1" style="border: 1px solid silver;">
  <tr>
    <td style="color: white;" bgcolor="#669966">Quick Ad</td>
  </tr>
  <tr>
    <td>

<table width="100%" cellspacing="0" cellpadding="4" border="0">
  <tr>
    <td align="right" valign="top"><strong>Your Ad:</strong></td>
    <td><span style="font-size: small; color: #333333;">Who what when where how why? Be sure to include how you want people to contact you.</span><br>
        <input type="text" name="description" value="" size="80">
    </td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong>Classifications:</strong></td>
    <td><!-- span style="font-size: small; color: #333333;">Hold down the control (Win) / command (Mac) button to select multiple options</span><br -->
        <select name="classifications[]"><!-- size="1" multiple -->
        <option value="13">Local Interest</option>
        <option value="1">Autos</option>
        <option value="4">Trucks</option>
        <option value="16">Vans</option>
        <option value="5">Furniture</option>
        <option value="6">Clothing</option>
        <option value="10">Books</option>
        <option value="12">Crafts</option>
        <option value="7">Tools</option>
        <option value="14">Bikes, Boats, & Snowmobiles</option>
        <option value="8">Bldg. Materials</option>
        <option value="2">Employment</option>
        <option value="9">Lost & Found</option>
        <option value="3">Miscellaneous</option>
        <option value="11">Announcements</option>
        <option value="15">Give Aways</option>
        <option value="17">Antiques</option>
        <option value="21">Coins</option>
        <option value="18">Entertainment</option>
        <option value="19">Real Estate</option>
        <option value="20">Wanted to Buy</option>
      </select>
    </td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong>Your Email:</strong></td>
    <td><span style="font-size: small; color: #333333;">Not included in the ad.</span><br>
        <input type="text" name="email" value="" size="80">
    </td>
  </tr>
  <tr>
    <td valign="top"></td>
    <td><input type="submit" value="Send Ad Request"></td>
  </tr>
</table>


    </td>
  </tr>
</table>
</p>
</form>



        </td>
    </tr>
</table>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12386213-7']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
