class GameStart extends Phaser.Scene {

  constructor() {
    super('GameStart');
  }



  preload() {

    this.load.image('bg_start', 'bg/pixel_floating_islands.png');
    this.load.image('platform_start', 'objects/pixel_platform_medium_green1.png');
    this.load.image('ground_start', 'objects/pixel_ground_green1.png');

    this.load.image('woodblock', 'objects/pixel_woodblock.png');

    this.load.spritesheet('bunny', 'sprites/pixel_bunny_sprite.png', {
      frameWidth: 80,
      frameHeight: 80
    });

    this.load.spritesheet('dust_light', 'sprites/pixel_dustcloud_light.png', {
      frameWidth: 60,
      frameHeight: 40
    });

    this.load.spritesheet('arrows', 'sprites/pixel_arrow_controls.png', {
      frameWidth: 60,
      frameHeight: 70
    });

  }

  create(){

    //  Set the camera and physics bounds to be the size of bg image
    this.cameras.main.setBounds(0, 0, 2400, 1350);
    this.physics.world.setBounds(0, 0, 2400, 1350);
    this.center_x = this.physics.world.bounds.width / 2;
    this.center_y = this.physics.world.bounds.height / 2;

    this.add.image(0, 0, 'bg_start').setOrigin(0).setScale(1).setDepth(-100);


    this.movingPlatform = this.physics.add.image(this.center_x, this.center_y, 'platform_start');
    this.movingPlatform.setImmovable(true);
    this.movingPlatform.body.allowGravity = false;
	  this.movingPlatform.setDepth(-1);
    this.movingPlatform.setVelocityX(-50); // moving left at start

    this.ground = this.physics.add.staticGroup();
    var i = 0;
    var posx =160;
    var posy = this.physics.world.bounds.height-40;
    var stp = 320;
    for(i=0;i<8;i++){
      this.ground.create(posx, posy, 'ground_start').setScale(1).refreshBody();
      posx = posx + stp;
    }

    this.keyExit = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.ESC);
    this.cursors = this.input.keyboard.createCursorKeys();

    this.playerStart();
    this.addGear();


    this.cameras.main.startFollow(this.player, true, 0.05, 0.05);

    this.physics.add.collider(this.player, this.movingPlatform);
    //this.physics.add.collider(this.player, this.ground);
    this.physics.add.collider(this.player, this.ground, function(){
      // on collision
    });

    if( isTouch() || isDevice() ){
      this.addTouchControls();
    }

  }

  update(){

    if (this.movingPlatform.x >= this.physics.world.bounds.width-200) {
      this.movingPlatform.setVelocityX(-50);
    } else if (this.movingPlatform.x <= 200) {
      this.movingPlatform.setVelocityX(50);
    }

    this.playerUpdate();
    if (this.keyExit.isDown) {
      this.endGame();
    }

  }


  playerStart(){

        this.player = this.physics.add.sprite(this.center_x, this.center_y-100, 'bunny').setDepth(0);
        this.player.setBounce(0.2);
        this.player.setCollideWorldBounds(true);
    	  this.player.body.checkCollision.up = false; // left, right, down
	      this.player.body.setMaxSpeed(1200);

        this.player.anims.create({
          key: 'left',
          frames: this.player.anims.generateFrameNumbers('bunny', {
            start: 0,
            end: 2
          }),
          frameRate: 10,
          repeat: -1
        });

        this.player.anims.create({
          key: 'leftjump',
          frames: [{
            key: 'bunny',
            frame: 3
          }],
          frameRate: 10
        });

        this.player.anims.create({
          key: 'rightjump',
          frames: [{
            key: 'bunny',
            frame: 9
          }],
          frameRate: 10
        });

        this.player.anims.create({
          key: 'turn',
          frames: [{
            key: 'bunny',
            frame: 6
          }],
          frameRate: 10
        });

        this.player.anims.create({
          key: 'right',
          frames: this.player.anims.generateFrameNumbers('bunny', {
            start: 10,
            end: 13
          }),
          frameRate: 10,
          repeat: -1
        });



  }


  playerUpdate(){


    if (this.player.body.position.y >= 800) {
      this.player.setBounce(0.4);
    }else{
      this.player.setBounce(0.2);
    }

    if (this.cursors.left.isDown || this.playerleft ) {
      this.playerMoveLeft();
    } else if (this.cursors.right.isDown || this.playerright ) {
      this.playerMoveRight();
    } else {
      this.playerMoveTurn(0);
    }
    if ( ( this.cursors.up.isDown || this.playerup ) && (this.player.body.touching.down || this.player.body.position.y >= this.physics.world.bounds.height-100) ) {
      this.playerMoveJump();
    }
    if( this.cursors.down.isDown || this.playerdown ){
      this.playerMoveDown();
    }

    /* drag two pointer jump
    // https://rexrainbow.github.io/phaser3-rex-notes/docs/site/touchevents/
    this.firstpointer = this.input.pointer1; //this.input.activePointer;
    this.secondpointer = this.input.pointer2; //this.input.pointer3;
    if (this.cursors.left.isDown || ( this.firstpointer.isDown && ( this.firstpointer.worldX < this.player.x-3 ) ) ) {
      this.playerMoveLeft();
    } else if (this.cursors.right.isDown || ( this.firstpointer.isDown && ( this.firstpointer.worldX >= this.player.x+3 ) ) ) {
      this.playerMoveRight();
    } else {
      this.player.setVelocityX(0);
      this.player.anims.play('turn', true);
    }
    if ( ( this.cursors.up.isDown || this.secondpointer.isDown  ) && (this.player.body.touching.down || this.player.body.position.y >= this.physics.world.bounds.height-100) ) {
      this.player.setVelocityY(-350);
    }
    if( this.cursors.down.isDown ){
      this.player.setVelocityY(250);
    }
    */


  }

  addGear(){
    this.gear = this.physics.add.group({
        key: 'woodblock',
        repeat: 25,
        setXY: { x: 12, y: 0, stepX: 180 }
    });
    this.gear.children.iterate(function (child) {
        child.setBounceY(Phaser.Math.FloatBetween(0.89, 0.98));
        child.setCollideWorldBounds(true);
    });
    this.physics.add.collider(this.gear, this.gear);
    this.physics.add.collider(this.gear, this.ground);
    this.physics.add.collider(this.gear, this.movingPlatform);
    this.physics.add.collider(this.gear, this.player);
  }

  addTouchControls(){

    this.touchcontrol_left = this.add.sprite(80, 780, 'arrows').setScrollFactor(0).setOrigin(0).setScale(1.6).setDepth(100).setFrame(1).setInteractive();
    this.touchcontrol_right = this.add.sprite(200, 780, 'arrows').setScrollFactor(0).setOrigin(0).setScale(1.6).setFlipX(true).setDepth(100).setFrame(1).setInteractive();
    this.touchcontrol_up = this.add.sprite(1820, 700, 'arrows').setScrollFactor(0).setOrigin(0).setScale(1.6).setAngle(90).setDepth(100).setFrame(1).setInteractive();
    this.touchcontrol_down = this.add.sprite(1820, 820, 'arrows').setScrollFactor(0).setOrigin(0).setScale(1.6).setFlipX(true).setAngle(90).setDepth(100).setFrame(1).setInteractive();

    this.playerleft = false;
    this.playerright = false;
    this.playerup = false;
    this.playerdown = false;

    var main = this;

    this.touchcontrol_left.on('pointerover', function(e) {
      this.setFrame(0);
      main.playerleft = true;
    });
    this.touchcontrol_left.on('pointerout', function(e) {
      this.setFrame(1);
      main.playerleft = false;
    });
    this.touchcontrol_right.on('pointerover', function(e) {
      this.setFrame(0);
      main.playerright = true;
    });
    this.touchcontrol_right.on('pointerout', function(e) {
      this.setFrame(1);
      main.playerright = false;
    });
    this.touchcontrol_up.on('pointerover', function(e) {
      this.setFrame(0);
      main.playerup= true;
    });
    this.touchcontrol_up.on('pointerout', function(e) {
      this.setFrame(1);
      main.playerup = false;
    });
    this.touchcontrol_down.on('pointerover', function(e) {
      this.setFrame(0);
      main.playerdown = true;
    });
    this.touchcontrol_down.on('pointerout', function(e) {
      this.setFrame(1);
      main.playerdown = false;
    });

  }

  playerMoveLeft(){
    this.player.setVelocityX(-250);
    if( (!this.player.body.touching.down && this.player.body.position.y < this.physics.world.bounds.height-100)){
        this.player.anims.play('leftjump', true);
    }else{
        this.player.anims.play('left', true);
    }
  }

  playerMoveRight(){
    this.player.setVelocityX(250);
    if( (!this.player.body.touching.down && this.player.body.position.y < this.physics.world.bounds.height-100)){
        this.player.anims.play('rightjump', true);
    }else{
        this.player.anims.play('right', true);
    }
  }

  playerMoveTurn(){
    this.player.setVelocityX(0);
    this.player.anims.play('turn', true);
  }

  playerMoveJump(){
    this.player.setVelocityY(-350);
  }

  playerMoveDown(){
    this.player.setVelocityY(200);
  }



  endGame() {
    game.scene.stop('GameStart');
    game.scene.start('GameEnd');
  }
}
