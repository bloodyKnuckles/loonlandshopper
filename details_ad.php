<?php

require($global.$db_access_path);

// GET CLASSIFIED AD
$sql = "SELECT title, description, photos";
$sql .= ", price, renew_date, a.create_date";
$sql .= ", phone, city, state, zip";
$sql .= " FROM Classifieds AS a, Users AS b";
$sql .= " WHERE a.key_Users = b.key_Users";
$sql .= " AND key_Classifieds = " . $_GET['key_Classifieds'];
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
<?php

require("common/navigation.php");

?></td>

    <td valign="top">
      <table border="0">

<!-- WRITE CLASSIFIED AD TABLE -->
<table>

<!-- TITLE -->
  <tr>
    <td align="right" valign="top" class="label">
      <span style="font-size: 18px; font-weight: bold;">&nbsp;</span>Title:</td>
    <td style="font-size: 18px; font-weight: bold;">
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
if ( is_file($photo_path . $classified_ad[0]["photos"]) ) { 

?>
  <tr>
    <td align="right" valign="top" class="label">
      Photo:</td>
    <td><img 
      src="photos/<?=$classified_ad[0]['photos']?>" /></td>
  </tr>
<?php } ?>


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
<?php
/*/
<!-- CITY STATE ZIP -->
  <tr>
    <td align="right" valign="top">
      City, State Zip:</td>
    <td>
      <?=$classified_ad[0]["city"]?>
      , <?=$classified_ad[0]["state"]?>
      <?=$classified_ad[0]["zip"]?></td>
  </tr>
//*/
?></table></td>
  </tr>
</table>
