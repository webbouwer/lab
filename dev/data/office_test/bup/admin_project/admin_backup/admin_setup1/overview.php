<?php
include( '../net/wp-load.php' );
include( '../net/wp-blog-header.php' );
if( !is_user_logged_in() || !current_user_can('manage_options') ) {
	header("location: http://oddsized.com/net/login");
}
require_once('assets/main.php'); 

$main = new main;
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Overview</title>
</head>

<body> 
<?php 
echo $main->getClientOverviewTable();
?>
</body>
</html> 
