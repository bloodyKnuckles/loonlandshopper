#!/usr/bin/perl -w

use strict;
use CGI qw( :standard );
use DBI;
use lib "/usr/home/jayblu/inc";

# DISPLAY ERROR MESSAGES
BEGIN { $| = 1; open (STDERR, ">&STDOUT"); print qq~Content-type: text/html\n\n~; }

my $sql = '';

my $email = '';
$email = param( 'email' ) if defined( param( 'email' ));

my ($item, $item2, $item3, $item4, $item5) = split /, */, param( 'item' ) if defined( param( 'item' ));

$item = '' if !defined($item);
$item2 = '' if !defined($item2);
$item3 = '' if !defined($item3);
$item4 = '' if !defined($item4);
$item5 = '' if !defined($item5);



# CONNECT TO READ DATABASE
require "db_jayblu_ls_read.pl";
my $db_ls_read = DBI->connect(&db_jayblu_ls_read) 
  or die "Could not connect to read ls DB";

# GET TOTAL PROPERTIES
$sql = "SELECT ";
$sql .= " key_Classifications";
$sql .= ", classification";
$sql .= " FROM Classifications";
$sql .= " ORDER BY display_order";
my $classifications_db = $db_ls_read->prepare($sql);
$classifications_db->execute;


print qq~

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

<form id="emailalert" action="email_alert_process.cgi" method="post" onSubmit="return validate('emailalert','email');">

<br>
<table border="0" width="590" cellspacing="0" cellpadding="0">

  <tr>
    <td valign="top" style="font-size: large; font-weight: bold; color: #999999;">Expanded Alert Form</td>
  </tr>

  <tr>
    <td valign="top" width="50%">

      <p><strong>E-Mail Address</strong> <span style="font-size: small; color: #666666;">(Required)</span><br>
      <span style="font-size: small; color: #666666;">Enter your e-mail address.</span><br>
      <input type="text" name="email" value="$email" size="30" style="background-color: #F9F9F9;"></p>

      <p><strong>Alert Items</strong> <span style="font-size: small; color: #666666;">(Optional)</span><br>
      <span style="font-size: small; color: #666666;">Enter one item per text box, up to 5.</span><br>
      1. <input type="text" name="item" value="$item" size="20" style="background-color: #F9F9F9;"></p>

      <p>2. <input type="text" name="item2" value="$item2" size="20" style="background-color: #F9F9F9;"></p>

      <p>3. <input type="text" name="item3" value="$item3" size="20" style="background-color: #F9F9F9;"></p>

      <p>4. <input type="text" name="item4" value="$item4" size="20" style="background-color: #F9F9F9;"></p>

      <p>5. <input type="text" name="item5" value="$item5" size="20" style="background-color: #F9F9F9;"></p>

      <p style="font-size: small; color: #666666;">
      Complete this form and click the "Save Alert"
      button. Reuse this form as often as necessary.
      Leave Alert Items and Classifications blank to 
      receive all new items.</p>

      <p><input type="submit" value="Save Alert"></p>

    </td>
    <td valign="top" width="50%">

      <p><strong>Classifications</strong> <span style="font-size: small; color: #666666;">(Optional)</span><br>
      <span style="font-size: small; color: #666666;">Select as many classifications as you like.</span><br>

~;


if ( 0 < $classifications_db->rows ) {
  while ( my @array = $classifications_db->fetchrow_array ) {
    print qq~

      <input type="checkbox" name="classifications" value="$array[1]"> $array[1]<br>

    ~;
  }
}
$classifications_db->finish;


print qq~

      </p>
    </td>
  </tr>

</table>

</form>

~;

1;
