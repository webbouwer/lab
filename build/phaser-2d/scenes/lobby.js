class GameLobby extends Phaser.Scene {

  constructor() {
    super('GameLobby');
  }

  preload() {
    this.load.image('bg_lobby', 'media/bg/pixel_floating_islands.png');
  }

  create(){

    this.add.image(0, 0, 'bg_lobby').setOrigin(0).setScale(0.8);

    var infotxt = 'Press Space to start';
    if( isTouch() || isDevice() ){
      infotxt = 'Tab to start';
    }

    this.openingText = this.add.text(
      this.physics.world.bounds.width / 2,
      this.physics.world.bounds.height / 2,
      infotxt, {
        fontFamily: 'Monaco, Courier, monospace',
        fontSize: '50px',
        fill: '#ffffff'
      },
    );
    this.openingText.setOrigin(0.5);

    // keyboard
    this.cursors = this.input.keyboard.createCursorKeys(); //console.log(Phaser.Input.Keyboard.KeyCodes);

    // touchscreen
    document.body.addEventListener('touchstart', function(e){
  		if (!game.scene.gameStarted) {
  		  game.scene.gameStarted = true;
        game.scene.stop('GameLobby');
        game.scene.start('GameStart');
  		}
  	});

    this.gameStarted = false;
  }

  update(){

    if (!this.gameStarted) {
      if ( this.cursors.space.isDown ) {
        this.gameStarted = true;
      }
    }else{
      this.startGame();
    }

  }

  startGame() {
    this.openingText.setVisible(false);
    game.scene.stop('GameLobby');
    game.scene.start('GameStart');
  }

}
