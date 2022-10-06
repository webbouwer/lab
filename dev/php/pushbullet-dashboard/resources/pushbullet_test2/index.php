<?php 

require 'PushBullet.class.php';
require 'config.php';



function sendbullet( $device, $title, $content, $acces_token ){

	// device = empty, code or email address
	try {
	
	  $p = new PushBullet( $acces_token );
	  
	  $p->pushNote($device, $title, $content);
	  
	  return 'Msg send to '.$device;
		
	} catch (PushBulletException $e) {
	  // Exception handling
	  return($e->getMessage());
	}
	
}



?>










<h3>Push message with PushBullet</h3>

<?php

if( $_POST["msg"] !=''){
	
	if( $_POST["msg"] !='' && $_POST["pass"] == $acces_pass){ 
	
		$dev = $_POST['dev'];
		$tit = $_POST['tit'];
		$msg = $_POST['msg'];
		$com = sendbullet( $dev, $tit, $msg, $acces_token );
		
	}else{
	
		$com = 'Empty or incorrect form field input.';
		
		if($_POST["pass"] != $acces_pass){
			$com = 'Incorrect password to send messages.';
		}
		
	}
	echo '<div>'.$com.'</div>';
	
}



?>

<form action="index.php" method="post">

    
    <?php if( $_POST["pass"] == $acces_pass ){ ?>
    
    
	<input type="hidden" name="pass" value="<?php echo $acces_pass; ?>">
    
    <?php 
	
    $p = new PushBullet( $acces_token );
	
	//print_r( $p->getDevices() ); //nickname / iden
	$pushlist = $p->getPushHistory( strtotime('-30 days') );
	
	foreach($p->getDevices() as $device){
	
		if( count($device) > 0 ){
		
			//print_r($device);
			echo '<select name="dev">';
			echo '<option value="">All devices</option>';
			foreach($device as $obj){
				
				
				if( isset($obj->pushable) && isset($obj->nickname) ){
					echo '<option value="'.$obj->iden.'">'.$obj->nickname.' - '. $obj->model.' - '. $obj->iden.'</option>';
				}
			}
			echo '</select><br />';
		}
	}
                                              
    
	?>
    
    Title: <input type="text" name="tit"><br>
    
	Message: <input type="text" name="msg"><br>
     
    <?php }else{ ?>
    
	<p>An msg dashboard experiment with the PushBullet.class v2</p>
	Your passsword please:  <input type="password" name="pass"><br>
    
    <?php } ?>
	<input type="submit" value="Submit">
</form>
 
 
<?php

	if( isset( $pushlist) ){
		print_r( $pushlist );
		
	}

?>
 
<?php

/*
session_start();

require 'PushBullet.class.php';
require 'config.php';


if( $_POST["pass"] !='' || $_POST["pass"] == $acces_pass ){
	
	$_SESSION["pass"] == $_POST["pass"];
	
	
}else if( $_SESSION["pass"] == $acces_pass || $_POST["pass"] == $acces_pass ){

	if( $_POST["msg"] !=''){

	$dev = $_POST['dev'];
	$tit = $_POST['tit'];
	$msg = $_POST['msg'];
	$com = sendbullet( $dev, $tit, $msg, $acces_token );
	
	echo $com;
	}


	echo '<form action="index.php" method="post">
	  Contact/Device: <input type="text" name="dev"><br>
	  Title: <input type="text" name="tit"><br>
	  Message: <input type="text" name="msg"><br>
	  Passsword: <input type="password" name="pass"><br> 
	  <input type="submit" value="Submit">
	</form>';
	
}else{

	echo '<form action="index.php" method="post">
	  Email: <input type="text" name="email"><br>
	  Passsword: <input type="password" name="pass"><br>
	  <input type="submit" value="Submit">
	</form>';
	
	unset( $_SESSION["pass"] );
	die();
	
}

function sendbullet( $device, $title, $content, $acces_token ){

	// device = empty, code or email address
	try {
	
	  $p = new PushBullet( $acces_token );
	  
	  $p->pushNote($device, $title, $content);
	  
	  return 'Msg send!';
		
	} catch (PushBulletException $e) {
	  // Exception handling
	  return($e->getMessage());
	}
	
}


if( $_SESSION["pass"] == $acces_pass ){



}

*/
?>