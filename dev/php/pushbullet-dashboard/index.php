<?php
/*
 * Push Bullet Dashboard
 */
require_once( 'resources/PushBullet.class.php' ); 



class PushBulletDashboard { 
    
    public  $owner;
    
	private $email;
	private $secret;
	private $token;
    
    public function PushBulletDashboard(){
                
        $this->owner = $this;
        $this->setConfig();
    }
     
    private function setConfig(){
        
        require_once( 'src/config.php' );
        
        $this->secret   = $acces_pass;  // secret to change and share randomly
        $this->token    = $acces_token; // token to refresh and share randomly
        $this->email    = $acces_email; // token owner email
        
    }
}



$d = new PushBulletDashboard();


?>
