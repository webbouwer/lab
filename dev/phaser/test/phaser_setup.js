/**/
class GameStart extends Phaser.Scene
{
    constructor ()
    {
        super('GameStart');
    }
		preload ()
    {
		
			this.load.image('logo', 'https://raw.githubusercontent.com/photonstorm/phaser-examples/master/examples/assets/sprites/phaser.png');
    		this.load.image('bg', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/background.png');
			this.load.image('platform', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/objects/platform1.png');
		}
		
    create ()
    {
        this.add.image(0, 0, 'bg').setOrigin(0).setScale(1.6);
				
				this.movingPlatform = this.physics.add.image(400, 380, 'platform');
    		this.movingPlatform.setImmovable(true);
    		this.movingPlatform.body.allowGravity = false;
				
				this.logo = this.physics.add.image(400, 100, 'logo');
    		this.logo.setBounce(0.8);
				
    		this.physics.add.collider(this.logo, this.movingPlatform);
				
				this.openingText = this.add.text(
					this.physics.world.bounds.width / 2,
					this.physics.world.bounds.height-200,
					'Press SPACE to Start',
					{
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
		
    update()
    {
			if (!this.gameStarted) {
			
				if (this.cursors.space.isDown) {
					this.gameStarted = true;
					this.openingText.setVisible(false);
				}
			
				if (this.movingPlatform.y >= 380)
				{
						this.movingPlatform.setVelocityY(-10);
				}
				else if (this.movingPlatform.y <= 360)
				{
						this.movingPlatform.setVelocityY(10);
				}
			}else{
				this.startGame();
			}
		}
		
		startGame() 
		{
				game.scene.stop('GameStart');
				game.scene.start('GameScene1');
    }
		
}


class GameScene1 extends Phaser.Scene
{
    constructor ()
    {
        super('GameScene1');
    }

    preload ()
    {
    	this.load.image('bg', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/background.png');
    	this.load.spritesheet('dude', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sprites/dude.png', { frameWidth: 32, frameHeight: 48 });
			this.load.image('ground', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/objects/platform3.png');
			this.load.image('platform', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/objects/platform1.png');
    }

    create ()
    {
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
						frames: this.player.anims.generateFrameNumbers('dude', { start: 0, end: 3 }),
						frameRate: 10,
						repeat: -1
				});

				this.player.anims.create({
						key: 'turn',
						frames: [ { key: 'dude', frame: 4 } ],
						frameRate: 20
				});

				this.player.anims.create({
						key: 'right',
						frames: this.player.anims.generateFrameNumbers('dude', { start: 5, end: 8 }),
						frameRate: 10,
						repeat: -1
				});
				
				
        this.cursors = this.input.keyboard.createCursorKeys();
				
        this.cameras.main.startFollow(this.player, true, 0.05, 0.05);
				
				this.platforms = this.physics.add.staticGroup();
    		this.platforms.create(300, 1100, 'ground').setScale(1).refreshBody();
    		this.platforms.create(1600, 700, 'ground').setScale(1).refreshBody();
    		this.platforms.create(300,300, 'ground').setScale(1).refreshBody();
				
				this.movingPlatform = this.physics.add.image(710, 1100, 'platform');
    		this.movingPlatform.setImmovable(true);
    		this.movingPlatform.body.allowGravity = false;
    		this.movingPlatform.setVelocityX(50);
				this.movingPlatform.setVelocityY(-40);
				
    		this.physics.add.collider(this.player, this.platforms);
				this.physics.add.collider(this.player, this.movingPlatform);
				
				this.keyExit = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.ESC);
    }

    update()
    {
        //this.player.setVelocity(0);

      if (this.cursors.left.isDown)
			{
					this.player.setVelocityX(-160);
					this.player.anims.play('left', true);
			}
			else if (this.cursors.right.isDown)
			{
					this.player.setVelocityX(160);
					this.player.anims.play('right', true);
			}
			else
			{
					this.player.setVelocityX(0);
					this.player.anims.play('turn', true);
			}

			if (this.cursors.up.isDown && ( this.player.body.touching.down || this.player.body.position.y >= 1150) )
			{
					this.player.setVelocityY(-330);
			}
			
			
			
			if (this.movingPlatform.x >= 1210)
			{
					this.movingPlatform.setVelocityX(-50);
			}
			else if (this.movingPlatform.x <= 710)
			{
					this.movingPlatform.setVelocityX(50);
			}
			if (this.movingPlatform.y >= 1100)
			{
					this.movingPlatform.setVelocityY(-40);
			}
			else if (this.movingPlatform.y <= 300)
			{
					this.movingPlatform.setVelocityY(40);
			}
			
			if (this.keyExit.isDown)
			{
					this.endGame();
			}
			
			
    }
		
		endGame() 
		{
				game.scene.stop('GameScene1');
				game.scene.start('GameEnd');
    }
		
}



class GameEnd extends Phaser.Scene
{
    constructor ()
    {
        super('GameEnd');
    }
		preload ()
    {
		
			this.load.image('logo', 'https://raw.githubusercontent.com/photonstorm/phaser-examples/master/examples/assets/sprites/phaser.png');
    	this.load.image('bg', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/background.png');
			this.load.image('platform', 'https://raw.githubusercontent.com/photonstorm/phaser3-examples/master/public/assets/sets/objects/platform1.png');
		}
		
    create ()
    {
        this.add.image(0, 0, 'bg').setOrigin(0).setScale(1.6);
				
				this.movingPlatform = this.physics.add.image(400, 380, 'platform');
    		this.movingPlatform.setImmovable(true);
    		this.movingPlatform.body.allowGravity = false;
				
				this.logo = this.physics.add.image(400, 100, 'logo');
    		this.logo.setBounce(0.8);
				
    		this.physics.add.collider(this.logo, this.movingPlatform);
				
				this.openingText = this.add.text(
					this.physics.world.bounds.width / 2,
					this.physics.world.bounds.height-200,
					'Thank you for playing!',
					{
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
		
    update()
    {
			if (!this.gameStarted) {
			
				if (this.cursors.space.isDown) {
					this.gameStarted = true;
					this.openingText.setVisible(false);
				}
			
				if (this.movingPlatform.y >= 380)
				{
						this.movingPlatform.setVelocityY(-10);
				}
				else if (this.movingPlatform.y <= 360)
				{
						this.movingPlatform.setVelocityY(10);
				}
			}else{
			
				this.endGame();
			}
			
			
    }
		
		endGame() 
		{
			
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
            gravity: { y: 300 },
            debug: false
        }
    },
    scene: [
        GameStart,
        GameScene1,
				GameEnd
    ],
};

const game = new Phaser.Game(config);