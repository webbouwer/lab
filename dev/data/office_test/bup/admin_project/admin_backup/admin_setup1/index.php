<?php
include( '../net/wp-load.php' );
include( '../net/wp-blog-header.php' );
if( !is_user_logged_in() || !current_user_can('manage_options') ) {
	header("location: http://oddsized.com/net/login");
}
?>
<html>
<head>
	<title>Oddsized admin</title>
</head>
<body style="margin:0;padding:0;">

<?php if ( is_user_logged_in() && current_user_can('manage_options') ) { ?>
<div style="width:30%;margin:5% auto;">

	<ul>
    <li>Clients</li>
    <li>Invoices</li>
    <li>back to network</li>
    </ul>
    
</div>
<?php }
 ?>

</body>