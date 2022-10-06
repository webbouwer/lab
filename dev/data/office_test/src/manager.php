<?php
class manager extends admin{

	public function manager(){
	}
	
	public function loadEntities(){
	
		include( $this->getSourceFolder() .'entity.php' );
		
		if( $ents = $this->rw->dataFromFile( 'entities.json' ) ){
		
			foreach( $ents as $id => $ent){
				$this->data['entities'][$id] = new entity( $id, $ent['fullname'] );
			}
		
			return $this->data['entities'];
		}else{
			$array = [];
			$this->rw->dataToFile( $array, 'entities.json' );
			$this->data['entities'] = $array;
			return false;
		}
	
	}
	
}
?>