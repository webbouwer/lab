<?php
/* AJAX */
include( '../../net/wp-load.php' );
include( '../../net/wp-blog-header.php' );
if( !is_user_logged_in() || !current_user_can('manage_options') ) {
	header("location: http://oddsized.com/net/login");
}

require_once('main.php'); 
$main = new main;

if( $_GET['iid'] ){

	echo $main->invoices[$_GET['iid']];

}
?>