/*
 * init.js
 */
 // load phaser in 'responsive' view
const config = {
  type: Phaser.AUTO,
  scale: {
    mode: Phaser.Scale.FIT,
    parent: 'phaser-example',
    autoCenter: Phaser.Scale.CENTER_BOTH,
    width:  1920,
    height: 960
  },
  input: {
    activePointers: 3
  },
  physics: {
    default: 'arcade',
    arcade: {
      gravity: {
        y: 400
      },
      debug: false
    }
  },
  scene: [
    GameLobby, 	// lobby.js
    GameStart, // start.js
	  GameEnd 	// end.js
  ],
};

const game = new Phaser.Game(config);
