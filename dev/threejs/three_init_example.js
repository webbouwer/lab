function initThree(config) {
    config = config || {};
    const container = config.container,
          addLights = (config.addLights !== false),
          addControls = (config.addControls !== false);

    const renderer = new THREE.WebGLRenderer();
    (container || document.body).appendChild(renderer.domElement);

    // create a scene
    const scene = new THREE.Scene();

    // put a camera in the scene
    const camera = new THREE.PerspectiveCamera(45, 16/9, .01, 1000);
    camera.position.set(10, 10, 10);
    camera.lookAt(0, 0, 0);
    scene.add(camera);

    // update camera and renderer to fit the window size
    function resize() {
        const w = window.innerWidth,
              h = window.innerHeight;

        var aspect = w / h;
        camera.aspect = aspect;
        camera.fov = 45 / ((aspect+1) / 2);
        camera.updateProjectionMatrix();

        renderer.setSize(w, h);
    }
    window.addEventListener('resize', resize, false);
    resize();

    //lighting
    if(addLights) {
        const light1 = new THREE.AmbientLight(0x888);
        const light2 = new THREE.PointLight(0xffffff);
        light2.position.set(50, 50, 50);
        scene.add(light1);
        scene.add(light2);
    }

    //Camera controls:
    let controls;
    if(addControls && THREE.OrbitControls) {
        controls = new THREE.OrbitControls(camera, renderer.domElement);
    }
    
    return {
        renderer,
        scene,
        camera,
        controls,
    };
}