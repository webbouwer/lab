
// GamePlay scene 1
class GameScene1 extends Phaser.Scene {
  constructor() {
    super('GameScene1');
  }

  preload() {
    this.load.image('bg2', 'media/bg/pxArt.png');
    this.load.spritesheet('nabi', 'media/sprite/pixel_bunny_sprite.png', {
      frameWidth: 80,
      frameHeight: 80
    });
	
    this.load.image('ground', 'media/object/ground_grass.png');
    this.load.image('bush', 'media/object/bg_bush_green.png');
    this.load.image('tree1', 'media/object/bg_tree_high1.png');
    this.load.image('tree2', 'media/object/bg_tree_high2.png');
    this.load.image('tree3', 'media/object/bg_tree_low1.png');
    this.load.image('tree4', 'media/object/bg_tree_low2.png');
	
    this.load.image('platform', 'media/object/plateau_medium_grass1.png');
	
    this.load.image('platform1', 'media/object/plateau_small_grass1.png');
    this.load.image('platform2', 'media/object/plateau_small_grass2.png');
    this.load.image('platform3', 'media/object/plateau_small_grass3.png');
	
	this.load.image('carrot1', 'media/object/item_carrot1.png'); 
	this.load.image('carrot2', 'media/object/item_carrot2.png'); 
  }

  create() {

    //  Set the camera and physics bounds to be the size of 4x4 bg images
    this.cameras.main.setBounds(0, 0, 1600 * 2, 600 * 2);
    this.physics.world.setBounds(0, 0, 1600 * 2, 600 * 2);


	  
    //this.add.image(0, 0, 'bg2').setOrigin(0).setScale(1.2).setDepth(-100);
    // scale and mirror bg
    this.add.image(0, 480, 'bg2').setOrigin(0).setScale(0.7).setDepth(-100);
    this.add.image(800 * 2, 480, 'bg2').setOrigin(0).setScale(0.7).setFlipX(true).setDepth(-100);

	// player
    this.player = this.physics.add.sprite(400, 1000, 'nabi').setDepth(0);

    this.player.setBounce(0.4);
    this.player.setCollideWorldBounds(true);
	this.player.body.setMaxSpeed(1200);
	
	// select collisions for player
	this.player.body.checkCollision.up = false;
	//this.player.body.checkCollision.left = false;
	//this.player.body.checkCollision.right = false;

    this.player.anims.create({
      key: 'left',
      frames: this.player.anims.generateFrameNumbers('nabi', {
        start: 0,
        end: 2
      }),
      frameRate: 10,
      repeat: -1
    });

    this.player.anims.create({
      key: 'leftjump',
      frames: [{
        key: 'nabi',
        frame: 3
      }],
      frameRate: 10
    });
	
	this.player.anims.create({
      key: 'rightjump',
      frames: [{
        key: 'nabi',
        frame: 9
      }],
      frameRate: 10
    });
	
	this.player.anims.create({
      key: 'turn',
      frames: [{
        key: 'nabi',
        frame: 6
      }],
      frameRate: 10
    });

    this.player.anims.create({
      key: 'right',
      frames: this.player.anims.generateFrameNumbers('nabi', {
        start: 10,
        end: 13
      }),
      frameRate: 10,
      repeat: -1
    });

    this.cursors = this.input.keyboard.createCursorKeys();

    this.cameras.main.startFollow(this.player, true, 0.05, 0.05);
	
	this.gear = this.physics.add.group({
        key: 'carrot2',
        repeat: 12,
        setXY: { x: 12, y: 0, stepX: 240 }
    });

    this.gear.children.iterate(function (child) {
        child.setBounceY(Phaser.Math.FloatBetween(0.4, 0.8));
    	child.setCollideWorldBounds(true);
    });
	
	// scenery
    this.add.image(40, 680, 'tree1').setOrigin(0).setScale(1).setDepth(-1);
    this.add.image(600, 690, 'tree2').setOrigin(0).setScale(1).setDepth(1);
    this.add.image(800, 780, 'tree4').setOrigin(0).setScale(1).setDepth(-1);
    this.add.image(1000, 680, 'tree1').setOrigin(0).setScale(1).setDepth(1);
    this.add.image(1300, 680, 'tree1').setOrigin(0).setScale(1).setDepth(-1);
    this.add.image(1500, 780, 'tree3').setOrigin(0).setScale(1).setDepth(-1);
    this.add.image(1800, 700, 'tree2').setOrigin(0).setScale(1).setDepth(-1); 
	
	
    this.add.image(2400, 690, 'tree2').setOrigin(0).setScale(1).setDepth(1);
    this.add.image(2600, 780, 'tree4').setOrigin(0).setScale(1).setDepth(-1);
    this.add.image(2800, 680, 'tree1').setOrigin(0).setScale(1).setDepth(1);
	
	var i = 0;
	var posx =0;
	var posy = 1020;
	var stp = 320;
	for(i=0;i<10;i++){
    	this.add.image(posx, posy, 'bush').setOrigin(0).setScale(1).setDepth(-2);
		posx = posx + stp; 
	}
	

	// elements
    this.platforms = this.physics.add.staticGroup();
	
	var i = 0;
	var posx =160;
	var posy = 1160;
	var stp = 320;
	for(i=0;i<10;i++){
    	this.platforms.create(posx, posy, 'ground').setScale(1).refreshBody();
		posx = posx + stp; 
	}
	
    this.platforms.create(1600, 500, 'ground').setScale(1).refreshBody();
    this.platforms.create(160, 300, 'ground').setScale(1).refreshBody();
    this.platforms.create(360, 300, 'ground').setScale(1).refreshBody();
    this.platforms.create(1400, 320, 'platform2').setScale(1).refreshBody();
    this.platforms.create(1980, 820, 'platform1').setScale(1).refreshBody();
    this.platforms.create(2280, 1000, 'platform3').setScale(1).refreshBody();
	
    this.movingPlatform = this.physics.add.image(710, 1040, 'platform');
    this.movingPlatform.setImmovable(true);
    this.movingPlatform.body.allowGravity = false;
    this.movingPlatform.setVelocityX(50);
    this.movingPlatform.setVelocityY(-40);
	
	this.platforms.setDepth(-1);
	this.movingPlatform.setDepth(-1);

    this.physics.add.collider(this.player, this.platforms);
    this.physics.add.collider(this.player, this.movingPlatform);
	
	this.physics.add.collider(this.gear, this.platforms);
    this.physics.add.collider(this.gear, this.movingPlatform);

    this.physics.add.overlap(this.player, this.gear, this.collectStar, null, this);

    this.keyExit = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.ESC);
	
	document.body.addEventListener('touchstart', function(e){
		this.player.setVelocityY(-450);
	});

  }
    
  
  update(){
    //this.player.setVelocity(0);
    if (this.cursors.left.isDown) {
      this.player.setVelocityX(-200);
	  if( (!this.player.body.touching.down && this.player.body.position.y < 1100)){
      	this.player.anims.play('leftjump', true);
	  }else{
      	this.player.anims.play('left', true);
	  }
    } else if (this.cursors.right.isDown) {
      this.player.setVelocityX(200);
	  if( (!this.player.body.touching.down && this.player.body.position.y < 1100)){
      	this.player.anims.play('rightjump', true);
	  }else{
      	this.player.anims.play('right', true);
	  }
    } else {
      this.player.setVelocityX(0);
      this.player.anims.play('turn', true);
    }
	/*
	if(this.cursors.up.isDown ){
	  this.player.setBounce(1.2);
	}
	if( this.cursors.down.isDown ){
	  this.player.setBounce(0.2);
    }
	*/

    if (this.cursors.up.isDown && (this.player.body.touching.down || this.player.body.position.y >= 1100)) {
	  this.player.setVelocityY(-450);
    } 
	
	if( this.cursors.down.isDown ){
	  this.player.setVelocityY(250);
    }
	
    if (this.movingPlatform.x >= 1210) { 
      this.movingPlatform.setVelocityX(-50);
    } else if (this.movingPlatform.x <= 710) {
      this.movingPlatform.setVelocityX(50);
    }
    if (this.movingPlatform.y >= 1080) {
      this.movingPlatform.setVelocityY(-40);
    } else if (this.movingPlatform.y <= 300) {
      this.movingPlatform.setVelocityY(40);
    }

    if (this.keyExit.isDown) {
      this.endGame();
    }
	
  }
  endGame() {
    game.scene.stop('GameScene1');
    game.scene.start('GameEnd');
  }

  
  collectStar(player, gear) {
			gear.disableBody(true, true);
	}

}


	

