#!/usr/bin/perl

use CGI::Carp qw(fatalsToBrowser);	# display errors to browser - debugging!

$CGI::POST_MAX=1024 * 100;  # limit size of POSTs to max 100K
$CGI::DISABLE_UPLOADS = 1;  # disable possibility of uploads

$|++;								#     Flush output buffer.

$q = new CGI;

$action = $q->param('email');
