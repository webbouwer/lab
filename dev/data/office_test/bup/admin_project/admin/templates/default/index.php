<html>
    <head>
        <title>Admin Start</title>
        <link href="<?php echo $admin->getThemeFolder(); ?>style.css" rel="stylesheet" type="text/css" />
    </head>
<body>
 
	<?php include( 'header.php' ); ?>
    
    <div id="dashboardscreen">
    
        <div class="maincolumn">
        <?php print_r( $admin->clients ); ?>
        </div>
       
        <div class="sidecolumn">
        
        </div>
    
    </div>
   
    <?php include( 'footer.php' ); ?>

</body></html>