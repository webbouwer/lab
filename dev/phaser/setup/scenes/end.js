class GameEnd extends Phaser.Scene {
  constructor() {
    super('GameEnd');
  }

  preload() {
    this.load.image('bg_end', 'bg/pixel_pilar_world.png');
  }
  create(){

    this.add.image(-300, -400, 'bg_end').setOrigin(0).setScale(0.8).setDepth(-100);

    this.openingText = this.add.text(
      this.physics.world.bounds.width / 2,
      this.physics.world.bounds.height - 200,
      'Press SPACE or ESC to reload', {
        fontFamily: 'Monaco, Courier, monospace',
        fontSize: '50px',
        fill: '#35B8FF'
      },
    );
    this.openingText.setOrigin(0.5);

    this.cursors = this.input.keyboard.createCursorKeys(); //console.log(Phaser.Input.Keyboard.KeyCodes);
    this.keyExit = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.ESC);

  }
  update(){

    if ( this.keyExit.isDown || this.cursors.space.isDown) {
      this.openingText.setVisible(false);
      this.endGame();
    }

  }

  endGame() {
    game.scene.stop('GameEnd');
    game.scene.start('GameLobby');
  }

}
