class GameStart extends Phaser.Scene {
  constructor() {
    super('GameStart');
  }
  preload() {
    this.load.image('logo', 'https://raw.githubusercontent.com/photonstorm/phaser-examples/master/examples/assets/sprites/phaser.png');
    this.load.image('bg1', 'media/bg/chinese_mountains_pixelated.png');
    this.load.image('platform', 'media/object/plateau_medium_grass1.png');
  }
  create() {
	 
	  
    this.add.image(0, 0, 'bg1').setOrigin(0).setScale(1.2);

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
	document.body.addEventListener('touchstart', function(e){
		if (!game.scene.gameStarted) {				  
		game.scene.gameStarted = true;
    	game.scene.stop('GameStart');
    	game.scene.start('GameScene1');
		}
	});

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