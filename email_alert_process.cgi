#!/usr/bin/perl -w

use strict;
use CGI qw( :standard );
use DBI;
use lib "/usr/home/jayblu/inc";

# DISPLAY ERROR MESSAGES
#BEGIN { $| = 1; open (STDERR, ">&STDOUT"); print qq~Content-type: text/html\n\n~; }

#foreach ( param ) {
#  print $_ . '<br>';
#}

my $sql = '';
my $delimiter = '';

my $now_date = `date +'%Y%m%d%H%M%S'`;
chomp $now_date;

# CONNECT TO WRITE DATABASE
require "db_jayblu_ls_write.pl";
my $db_ls_write = DBI->connect(&db_jayblu_ls_write) 
  or die "Could not connect to write ls DB";


my $email = '';
$email = param( 'email' ) if defined( param( 'email' ));

if ( $email =~ /^[^@]+@([a-z0-9-]+\.)+[a-z]+/ ) {

  my ($item, $item2, $item3, $item4, $item5) = split /, */, param( 'item' ) if defined( param( 'item' ));

  $item2 = param('item2') if defined( param('item2') );
  $item3 = param('item3') if defined( param('item3') );
  $item4 = param('item4') if defined( param('item4') );
  $item5 = param('item5') if defined( param('item5') );

  $delimiter = '';
  if ( defined($item) && '' ne $item ) { 
    $sql .= "$delimiter('$email', ";
    $sql .= $db_ls_write->quote( $item );
    $sql .= ", $now_date)";
    $delimiter = ',';
  }
  if ( defined($item2) && '' ne $item2 ) { 
    $sql .= "$delimiter('$email', ";
    $sql .= $db_ls_write->quote( $item2 );
    $sql .= ", $now_date)"; 
    $delimiter = ',';
  }
  if ( defined($item3) && '' ne $item3 ) { 
    $sql .= "$delimiter('$email', ";
    $sql .= $db_ls_write->quote( $item3 );
    $sql .= ", $now_date)"; 
    $delimiter = ',';
  }
  if ( defined($item4) && '' ne $item4 ) { 
    $sql .= "$delimiter('$email', ";
    $sql .= $db_ls_write->quote( $item4 );
    $sql .= ", $now_date)"; 
    $delimiter = ',';
  }
  if ( defined($item5) && '' ne $item5 ) { 
    $sql .= "$delimiter('$email', ";
    $sql .= $db_ls_write->quote( $item5 );
    $sql .= ", $now_date)"; 
    $delimiter = ',';
  }

  if ( defined(param( 'classifications' )) ) {
    $sql .= "$delimiter('$email', '";
    $sql .= join "', $now_date), ('$email', '", param( 'classifications' );
    $sql .="', $now_date)";
    $delimiter = ',';
  }

  # INSERT ALERTS
  if ( '' eq $sql ) { $sql = "('$email', '', $now_date)"; }
  $sql = 'INSERT INTO Alerts (email, item, create_date) VALUES ' . $sql;
  $db_ls_write->do($sql);
}

print 'Location: index.php?page=email_alert_thanks.html

';

1;
