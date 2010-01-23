#!/usr/bin/perl

use CGI::Carp qw(fatalsToBrowser);	# display errors to browser - debugging!

require "cgi-lib.pl";				# so we can easily retrieve info
									# from the query with: $in{'query'}
$|++;								#     Flush output buffer.
&ReadParse;

use CGI;
my $q =new CGI;

$cmd            = $in{'cmd'};
$business       = $in{'#################'};
$amount         = $in{'amount'};
$return         = $in{'return'};
$add            = $in{'add'};
$no_note        = $in{'no_note'};
$currency_code  = $in{'currency_code'};
$item_name      = $in{'item_name'};
$reserve_pref   = $in{'reserve_pref'};
$quantity       = $in{'quantity'};
$on0            = "Special Instructions";
$os0            = $in{'os0'};
$on1            = "";
$os1            = "";

if (uc($reserve_pref) eq "RESERVED SEATING ONLY") {
  $reserve_pref = "None";
}

if ($item_name eq 'Premier Reserved Seat ($25)') {
  $os1 = $reserve_pref;
  $on1 = "Reserved Seating Preference";
  $amount = "25.00";
} elsif ($item_name eq 'Reserved Seat ($20)') {
  $os1 = $reserve_pref;
  $on1 = "Reserved Seating Preference";
  $amount = "20.00";
} elsif ($item_name eq "'Blast Zone' Seat (\$15)") {
  $amount = "15.00";
} elsif ($item_name eq 'General Admission ($15)') {
  $amount = "15.00";
}

print "Content-type: text/html\n";					# let the browser know what it'll be reading
print "Location: https://www.paypal.com/cgi-bin/webscr?cmd=$cmd&business=$business&amount=$amount&add=$add&no_note=$no_note&currency_code=$currency_code&item_name=$item_name&quantity=$quantity&on0=$on0&on1=$on1&os0=$os0&os1=$os1&return=$return\n\n";
# print "Location: https://www.paypal.com/cgi-bin/webscr?cmd=$cmd&business=$business&amount=$amount&return=$return&add=$add&no_note=$no_note&currency_code=$currency_code&item_name=$item_name&quantity=$quantity&on0=$on0&on1=$on1\n\n";


