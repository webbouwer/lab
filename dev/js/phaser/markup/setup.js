
// load phaser in 'responsive' view
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
    GameStart, 	// start.js
    GameScene1, // scene1.js
	GameEnd 	// end.js
  ],
};

const game = new Phaser.Game(config);
