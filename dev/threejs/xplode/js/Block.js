/**
 * @author Felix Turner / http://www.airtightinteractive.com/
 */
var Block = function (scene) {
	
	var MAX_SIZE = 500;
	var MIN_SIZE = 80;

	//cerate randomly sized cube
	var geometry = new Cube(Math.random()*MAX_SIZE + MIN_SIZE, Math.random()*MAX_SIZE + MIN_SIZE, Math.random()*MAX_SIZE + MIN_SIZE);
	
	if (Math.random() < .1){
		//color orange
		for (var i = 0; i < geometry.faces.length; i++) {
			geometry.faces[i].color.setRGBA( Math.floor( Math.random() * 128 + 128), Math.floor( Math.random() * 66 ), 0, 255 );
		}
	}else{
		//color grey
		for (var i = 0; i < geometry.faces.length; i++) {
			var brightness = Math.floor( Math.random() * 216 + 40);
			geometry.faces[i].color.setRGBA( brightness, brightness, brightness, 255 );
		}
	}
	
	this.cube = new THREE.Mesh(geometry, new THREE.FaceColorFillMaterial());
	this.reset();
	scene.add(this.cube);
}

Block.prototype.reset = function(){
	
	var MAX_SPEED = 20;
	var MAX_ROT = .1;
	
	this.xd = Math.random()*MAX_SPEED*2 - MAX_SPEED ;
	this.yd = Math.random()*MAX_SPEED*2 - MAX_SPEED ;
	this.zd = Math.random()*MAX_SPEED*2 - MAX_SPEED ;

	this.xrd = Math.random()*MAX_ROT*2 - MAX_ROT;
	this.zrd = Math.random()*MAX_ROT*2 - MAX_ROT;
	
	this.cube.position.x = 0;
	this.cube.position.y = 0;
	this.cube.position.z = 0;

	this.cube.rotation.x = Math.random()*360;
	this.cube.rotation.z = Math.random()*360;
	
	this.ticks = 0;
	
}

Block.prototype.loop = function(){
	
	this.cube.position.x += this.xd;
	this.cube.position.y += this.yd;
	this.cube.position.z += this.zd;

	this.cube.rotation.x += this.xrd;
	this.cube.rotation.z += this.zrd;
	
	this.ticks ++;
	
	if (this.ticks > 100){
		this.reset();
	}
			
}