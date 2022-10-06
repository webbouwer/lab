/* Game start and scenes switch */
class GameStart extends Phaser.Scene {
  constructor() {
    super('GameStart');
  }
  preload() {
    this.load.image('logo', 'https://raw.githubusercontent.com/photonstorm/phaser-examples/master/examples/assets/sprites/phaser.png');
    this.load.image('bg', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/background.png');
    this.load.image('platform', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/objects/platform1.png');
  }
  create() {
	  
    this.add.image(0, 0, 'bg').setOrigin(0).setScale(1.6);
    this.movingPlatform = this.physics.add.image(400, 380, 'platform');
    this.movingPlatform.setImmovable(true);
    this.movingPlatform.body.allowGravity = false;

    this.logo = this.physics.add.image(400, 100, 'logo');
    this.logo.setBounce(0.8);

    this.physics.add.collider(this.logo, this.movingPlatform);

    this.openingText = this.add.text(
      this.physics.world.bounds.width / 2,
      this.physics.world.bounds.height - 200,
      'Press SPACE to Start', {
        fontFamily: 'Monaco, Courier, monospace',
        fontSize: '50px',
        fill: '#35B8FF'
      },
    );
    this.openingText.setOrigin(0.5);

    this.cursors = this.input.keyboard.createCursorKeys();
    //console.log(Phaser.Input.Keyboard.KeyCodes);
    this.gameStarted = false;
  }
  update() {
    if (!this.gameStarted) {
		
      if (this.cursors.space.isDown) {
        this.gameStarted = true;
        this.openingText.setVisible(false);
      }
      if (this.movingPlatform.y >= 380) {
        this.movingPlatform.setVelocityY(-10);
      } else if (this.movingPlatform.y <= 360) {
        this.movingPlatform.setVelocityY(10);
      }
	  
    } else {
      this.startGame();
    }
  }
  startGame() {
    game.scene.stop('GameStart');
    game.scene.start('GameScene1');
  }
}

// GamePlay scene 1
class GameScene1 extends Phaser.Scene {
  constructor() {
    super('GameScene1');
  }

  preload() {
    this.load.image('bg', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/background.png');
    this.load.spritesheet('dude', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sprites/dude.png', {
      frameWidth: 32,
      frameHeight: 48
    });
    this.load.image('ground', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/objects/platform3.png');
    this.load.image('platform', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/objects/platform1.png');
  }

  create() {
    //  Set the camera and physics bounds to be the size of 4x4 bg images
    this.cameras.main.setBounds(0, 0, 1600 * 2, 600 * 2);
    this.physics.world.setBounds(0, 0, 1600 * 2, 600 * 2);

    // scale and mirror bg
    this.add.image(0, 0, 'bg').setOrigin(0).setScale(1.6);
    this.add.image(800 * 2, 0, 'bg').setOrigin(0).setScale(1.6).setFlipX(true);

    this.player = this.physics.add.sprite(400, 1000, 'dude');

    this.player.setBounce(0.5);
    this.player.setCollideWorldBounds(true);

    this.player.anims.create({
      key: 'left',
      frames: this.player.anims.generateFrameNumbers('dude', {
        start: 0,
        end: 3
      }),
      frameRate: 10,
      repeat: -1
    });

    this.player.anims.create({
      key: 'turn',
      frames: [{
        key: 'dude',
        frame: 4
      }],
      frameRate: 20
    });

    this.player.anims.create({
      key: 'right',
      frames: this.player.anims.generateFrameNumbers('dude', {
        start: 5,
        end: 8
      }),
      frameRate: 10,
      repeat: -1
    });

    this.cursors = this.input.keyboard.createCursorKeys();

    this.cameras.main.startFollow(this.player, true, 0.05, 0.05);

    this.platforms = this.physics.add.staticGroup();
    this.platforms.create(300, 1100, 'ground').setScale(1).refreshBody();
    this.platforms.create(1600, 700, 'ground').setScale(1).refreshBody();
    this.platforms.create(300, 300, 'ground').setScale(1).refreshBody();

    this.movingPlatform = this.physics.add.image(710, 1100, 'platform');
    this.movingPlatform.setImmovable(true);
    this.movingPlatform.body.allowGravity = false;
    this.movingPlatform.setVelocityX(50);
    this.movingPlatform.setVelocityY(-40);

    this.physics.add.collider(this.player, this.platforms);
    this.physics.add.collider(this.player, this.movingPlatform);

    this.keyExit = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.ESC);
  }
  update(){
    //this.player.setVelocity(0);
    if (this.cursors.left.isDown) {
      this.player.setVelocityX(-160);
      this.player.anims.play('left', true);
    } else if (this.cursors.right.isDown) {
      this.player.setVelocityX(160);
      this.player.anims.play('right', true);
    } else {
      this.player.setVelocityX(0);
      this.player.anims.play('turn', true);
    }
    if (this.cursors.up.isDown && (this.player.body.touching.down || this.player.body.position.y >= 1150)) {
      this.player.setVelocityY(-330);
    }
    if (this.movingPlatform.x >= 1210) {
      this.movingPlatform.setVelocityX(-50);
    } else if (this.movingPlatform.x <= 710) {
      this.movingPlatform.setVelocityX(50);
    }
    if (this.movingPlatform.y >= 1100) {
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
}




// Game End Scene
class GameEnd extends Phaser.Scene {
  constructor() {
    super('GameEnd');
  }
  preload() {
    this.load.image('logo', 'https://raw.githubusercontent.com/photonstorm/phaser-examples/master/examples/assets/sprites/phaser.png');
    this.load.image('bg', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/background.png');
    this.load.image('platform', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/objects/platform1.png');
  }
  create() {
    this.add.image(0, 0, 'bg').setOrigin(0).setScale(1.6);

    this.movingPlatform = this.physics.add.image(400, 380, 'platform');
    this.movingPlatform.setImmovable(true);
    this.movingPlatform.body.allowGravity = false;

    this.logo = this.physics.add.image(400, 100, 'logo');
    this.logo.setBounce(0.8);

    this.physics.add.collider(this.logo, this.movingPlatform);

    this.openingText = this.add.text(
      this.physics.world.bounds.width / 2,
      this.physics.world.bounds.height - 200,
      'Thank you for playing!', {
        fontFamily: 'Monaco, Courier, monospace',
        fontSize: '50px',
        fill: '#35B8FF'
      },
    );
    this.openingText.setOrigin(0.5);

    this.cursors = this.input.keyboard.createCursorKeys(); //console.log(Phaser.Input.Keyboard.KeyCodes);
    this.gameStarted = false;
  }
  update() {
    if (!this.gameStarted) {
      if (this.cursors.space.isDown) {
        this.gameStarted = true;
        this.openingText.setVisible(false);
      }

      if (this.movingPlatform.y >= 380) {
        this.movingPlatform.setVelocityY(-10);
      } else if (this.movingPlatform.y <= 360) {
        this.movingPlatform.setVelocityY(10);
      }
    }else{
      this.endGame();
    }
  }
  endGame() {
    game.scene.stop('GameEnd');
    game.scene.start('GameStart');
  }
}

// responsive view
const config = {
  type: Phaser.AUTO,
  scale: {
    mode: Phaser.Scale.FIT,
    parent: 'phaser-example',
    autoCenter: Phaser.Scale.CENTER_BOTH,
    width: 800,
    height: 600
  },
  physics: {
    default: 'arcade',
    arcade: {
      gravity: {
        y: 300
      },
      debug: false
    }
  },
  scene: [
    GameStart,
    GameScene1, // load this in html!
    GameEnd
  ],
};

const game = new Phaser.Game(config);




/*
var GameScene = new Phaser.Class({

    Extends: Phaser.Scene,

    initialize:

    function GameScene ()
    {
        Phaser.Scene.call(this, { key: 'gameScene', active: true });

        this.player = null;
        this.cursors = null;
        this.score = 0;
        this.scoreText = null;
    },

    preload: function ()
    {

				    this.load.image('sky', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/background.png');
	 this.load.image('ground', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/objects/platform3.png');
	 this.load.image('platform1', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/objects/platform1.png');
	 
    this.load.image('star', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/games/asteroids/asteroid1.png');
		    this.load.image('bomb', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/games/asteroids/asteroid2.png');
		
    this.load.spritesheet('dude', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sprites/dude.png', { frameWidth: 32, frameHeight: 48 });
		
    },

    create: function ()
    {
				
        var player = this.player;
		
        //this.add.image(400, 300, 'sky');
        //  Set the camera and physics bounds to be the size of 4x4 bg images
        this.cameras.main.setBounds(0, 0, 800 * 2, 600);
				this.physics.world.setBounds(0, 0, 800 * 2, 600);

        //  Mash 4 images together to create our background
        for (let x = 0; x < 2; x++)
        {
            this.add.image(800 * x, -100, 'sky').setOrigin(0);
        }
				
        platforms = this.physics.add.staticGroup();

        platforms.create(400, 600, 'ground').setScale(2).refreshBody();

        platforms.create(600, 400, 'ground');
        platforms.create(50, 250, 'ground');
        platforms.create(750, 220, 'ground');
				
				movingPlatform = this.physics.add.image(400, 250, 'platform1');

				movingPlatform.setImmovable(true);
				movingPlatform.body.allowGravity = false;
				movingPlatform.setVelocityX(0);


        player = this.physics.add.sprite(100, 450, 'dude');

        player.setBounce(0.2);
        player.setCollideWorldBounds(true);

        this.anims.create({
            key: 'left',
            frames: this.anims.generateFrameNumbers('dude', { start: 0, end: 3 }),
            frameRate: 10,
            repeat: -1
        });

        this.anims.create({
            key: 'turn',
            frames: [ { key: 'dude', frame: 4 } ],
            frameRate: 20
        });

        this.anims.create({
            key: 'right',
            frames: this.anims.generateFrameNumbers('dude', { start: 5, end: 8 }),
            frameRate: 10,
            repeat: -1
        });

        this.cursors = this.input.keyboard.createCursorKeys();

        var stars = this.physics.add.group({
            key: 'star',
            repeat: 11,
            setXY: { x: 12, y: 0, stepX: 70 }
        });

        stars.children.iterate(function (child) {

            child.setBounceY(Phaser.Math.FloatBetween(0.4, 0.8));

        });

        this.scoreText = this.add.text(16, 16, 'score: 0', { fontSize: '32px', fill: '#000' });

        this.physics.add.collider(player, platforms);
        this.physics.add.collider(stars, platforms);
    		this.physics.add.collider(player, movingPlatform);
    		this.physics.add.collider(stars, movingPlatform);

        this.physics.add.overlap(player, stars, this.collectStar, null, this);

        this.player = player;
				
				//this.cameras.main.startFollow(this.player);
        //this.cameras.main.setZoom(1);
				this.cameras.main.startFollow(this.player, true, 0.05, 0.05);

    },

    update: function ()
    {
        var cursors = this.cursors;
        var player = this.player;
				const cam = this.cameras.main;
				
				
				
        player.setVelocity(0);
				


					if (cursors.left.isDown)
					{
							player.setVelocityX(-160);
							player.anims.play('left', true);
					}
					else if (cursors.right.isDown)
					{
							player.setVelocityX(160);
							player.anims.play('right', true);
					}
					else
					{
							player.setVelocityX(0);
							player.anims.play('turn');
					}

					if (cursors.up.isDown && player.body.touching.down)
					{
							player.setVelocityY(-330);
					}
	
				
				if (movingPlatform.x >= 800)
				{
						movingPlatform.setVelocityX(-50);
				}
				else if (movingPlatform.x <= 400)
				{
						movingPlatform.setVelocityX(50);
				}
				
    },

    collectStar: function (player, star)
    {
        star.disableBody(true, true);

        this.score += 10;
        this.scoreText.setText('Score: ' + this.score);
    }

});

var config = {
    type: Phaser.AUTO,
    scale: {
        mode: Phaser.Scale.FIT,
        parent: 'phaser-example',
        autoCenter: Phaser.Scale.CENTER_BOTH,
        width: 800,
        height: 600
    },
    physics: {
        default: 'arcade',
        arcade: {
            gravity: { y: 300 },
            debug: false
        }
    },
    scene: GameScene
};

var game = new Phaser.Game(config);
*/
