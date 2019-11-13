<?php

error_reporting(E_ALL);

require($global.$db_access_path);

// GET CLASSIFIEDS
$sql = "SELECT *";
$sql .= " FROM Classifieds_Classifications AS a";
$sql .= ", Classifieds AS b";
$sql .= " WHERE a.key_Classifieds = b.key_Classifieds";
$sql .= " AND a.key_Classifications = ".$_GET['key_Classifications'];
$sql .= " AND b.active = 1";
$sql .= " AND b.approved = 1";
$sql .= " AND renew_date >= ".mktime(23,1,59,date("m") - 2, date("d"), date("Y"));
$sql .= " ORDER BY b.create_date DESC";
$classifieds = db_execute_sql($sql, "jayblu_ls");
//echo $sql."<br />\n";

?>
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
<?php

if ( is_array($classifieds) && count($classifieds) > 0 ) {
  while ( list($key, $value) = each($classifieds) ) {
      $title = ('' != $value["title"] )? $value["title"]: substr($value["description"], 0, 40) . '...';
    echo "<tr>\n";
    echo "  <td>\n";
    echo "  <a href=\"index.php";
    echo "?page=details_ad.php";
    echo "&key_Classifieds=".$value["key_Classifieds"]."\" style=\"text-decoration: none;\">\n";
    echo "  &#171;  ".$title."</a></td>\n";
    echo "</tr>\n";
  }
} else {
  echo "<tr><td>No classified ads to display.</td></tr>\n";
}

?></table></td>
  </tr>
</table>
