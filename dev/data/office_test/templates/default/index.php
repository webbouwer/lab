<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Office Homepage</title>
<link href="<?php echo $admin->getThemeFolder(); ?>style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div>
	<?php include('topbar.php'); 

	//print_r( $admin->user );
	
	//print_r( $admin->data['entities']->structure );
	
    
	print_r( $admin->data['entities']->elist );
	?> 
    
</div>
</body>
</html>