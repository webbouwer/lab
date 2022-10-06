<div>
	<ul>
    	<li><a href="https://oddsized.com/office" target="_self">Start</a></li>
        <li><a href="https://oddsized.com/office/dashboard.php" target="_self">Dashboard</a></li>
    	<li>
        	<div>
            	<a href="https://oddsized.com/net/wp-admin/profile.php" target="_blank"><?php echo $admin->user->display_name; ?></a> |
            	<a href="https://oddsized.com/net/" target="_blank">WP</a> | 
            	<a href="<?php echo wp_logout_url( "https://oddsized.com/office" ); ?>" target="_self">Logout</a>
            </div>
        </li>
    </ul>
</div>