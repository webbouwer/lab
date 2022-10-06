<?php
//  Admin check with wordpress site
include( '../net/wp-load.php' );
include( '../net/wp-blog-header.php' );
if( !is_user_logged_in() || !current_user_can('manage_options') ) {
	header("location: http://oddsized.com/net/login");
}

require('assets/admin.php');
require('assets/client.php');

$admin = new admin;
 

include( $admin->getThemePage() ); // template file 
?>