<?php
require_once('src/admin.php');
$admin = new admin;
include( $admin->getThemePage() ); // template file 
?>