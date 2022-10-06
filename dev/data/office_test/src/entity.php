<?php
class entity {
	
	public function entity(){
	
	/*
		$this->types = ['person','business','organisation','foundation','goverment','ai'];
		$this->relations = ['personal','family','client','project','service','depend','entertainment','mixed'];
		
		$this->address = ['street','nr','nradd','postbox','city','state/region','entertainment','mixed'];
	*/ 
	}
	
	public function presetEntity(){
	
		return( [ 
			"id"=>false,
			"type"=>"", // person || business || organisation  || foundation || goverment || ai
			"relation"=>"", // personal, family, client, project, service, depend, entertainment
			"fullname"=>"",
			"contactname"=>"unknown",
			"address"=>[ 'work' => [] ], // work, home, private, second, finance, service, support, reply, system [ street, nr, postbox, city, state, nation ]
			"phone"=>['work' => ''], // work, home, private, second, finance, service, support, reply, system
			"email"=>['work' => ''], // work, home, private, second, finance, service, support, reply, system
			"web"=>['work' => ''], // work, home, private, second, finance, service, support, reply, system
			"notes"=>[], // date - notes string
			"log"=>[ date("Y m d H:i:s") => 'Registered' ],	// date - auto log message
		]);
		
	}
	
	public entityForm(){ 
	
	}





}
?>