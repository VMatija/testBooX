var camera, scene, renderer;
var mesh;
var weapon;
var geometry;
var controls;
var crosshair;
var blocker = document.getElementById( 'blocker' );
var instructions = document.getElementById( 'instructions' );
/* Check if browser support PointerLock */
var havePointerLock = 'pointerLockElement' in document || 'mozPointerLockElement' in document || 'webkitPointerLockElement' in document;
/* Enable or show err message */
if ( havePointerLock ) {
		/* Element(Body) must contain contain pointerLock */
		var element = document.body;
		/* Declare function on pointerLock change */
		var pointerlockchange = function ( event ) {
			if ( document.pointerLockElement === element || document.mozPointerLockElement === element || document.webkitPointerLockElement === element ) {
				controlsEnabled = true;
					controls.enabled = true;
			blocker.style.display = 'none';
		} else {
			controls.enabled = false;
			blocker.style.display = '-webkit-box';
			blocker.style.display = '-moz-box';
			blocker.style.display = 'box';
			instructions.style.display = '';
		}
};
/* Declare funtction for pointerLock error */
var pointerlockerror = function ( event ) {
	instructions.style.display = '';
};
// Hook pointer lock state change events
document.addEventListener( 'pointerlockchange', pointerlockchange, false );
document.addEventListener( 'mozpointerlockchange', pointerlockchange, false );
document.addEventListener( 'webkitpointerlockchange', pointerlockchange, false );
document.addEventListener( 'pointerlockerror', pointerlockerror, false );
document.addEventListener( 'mozpointerlockerror', pointerlockerror, false );
document.addEventListener( 'webkitpointerlockerror', pointerlockerror, false );
/* When div instruction is clicked request PointerLock */
instructions.addEventListener( 'click', function ( event ) {
	instructions.style.display = 'none';
	// Ask the browser to lock the pointer
	element.requestPointerLock = element.requestPointerLock || element.mozRequestPointerLock || element.webkitRequestPointerLock;
	element.requestPointerLock();
}, false );
} else {
	/* Otherwise browser doesnt support Pointer Lock */
	instructions.innerHTML = 'Your browser doesn\'t seem to support Pointer Lock API';
}

init();
animate();

/* Variables */
var controlsEnabled = false;
var moveForward = false;
var moveBackward = false;
var moveLeft = false;
var moveRight = false;
var canJump = false;
var prevTime = performance.now();
var MOVE_FACTOR = 1;

function init() {
	/*	GLAVNI GRADNIKI: Camera, Scene, Renderer
	Kamera THREE.PerspectiveCamera
				fieldOfView=> vidni kot
				AspectRation=>razmerje med višino in širino
				nearPlane=>kaj odreže na začetku
				farPlane=>kaj odreže na koncu
	camera.position.set(x,y,z);
	Oddaljenost predmeta po Z osi -> manjši kot je Z bližje je predmet 
	Po defaultu so kamera in objekti na (0,0,0) zato premaknemo kamero	*/
	camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 1000 );
	scene = new THREE.Scene();

	// ADD pointer lock controls
	controls = new THREE.PointerLockControls( camera );
	scene.add( controls.getObject() );

	// LIGHTS
	var ambientLight = new THREE.AmbientLight(0xffffff, 2);
	scene.add(ambientLight);

	var dirLight = new THREE.DirectionalLight(0xffffff, 1);
	dirLight.position.set(150, 150, 0);
	scene.add(dirLight);
	
	// SKYDOME
	var geometry = new THREE.SphereGeometry(400, 15, 15);
	var material = new THREE.MeshBasicMaterial();
	material.map = THREE.ImageUtils.loadTexture("images/Sky.jpg");
	material.side = THREE.BackSide;
	var skydome = new THREE.Mesh(geometry, material);
	skydome.position.set(0, 200, 0);
	scene.add(skydome);

	//initGeometry();
	initGun();
	intitCrosshair();
	initTerrain();

	renderer = new THREE.WebGLRenderer();
	renderer.setPixelRatio( window.devicePixelRatio );
	renderer.setSize( window.innerWidth, window.innerHeight );
	document.body.appendChild( renderer.domElement );

function initGeometry(){
	// Definiramo geometrijo
	var groundGeo = new THREE.PlaneGeometry(400,400);
	//Določimo teksturo geometriji, lahko damo tudi color namesto map npr: color: 0x00ff00 
	//var material = new THREE.MeshBasicMaterial( { map: texture } );
	var grassTex = new THREE.TextureLoader().load('textures/minecraft/dirt.png');
	grassTex.wrapS = THREE.RepeatWeapping;
	grassTex.wrapT = THREE.RepeatWeapping;
	grassTex.repeat.x = 16;
	grassTex.repeat.y = 16;
	var groundMat = new THREE.MeshBasicMaterial({map:grassTex});
	var ground = new THREE.Mesh(groundGeo,groundMat);
	ground.position.x = -1.9;
	ground.rotation.x = -Math.PI/2;
	ground.doubleSided = true;
	ground.receiveShadow = true;
	scene.add(ground);
}

	/* Funciton inside init on key down */
	var onKeyDown = function ( event ) {
		switch ( event.keyCode ) {
			case 38: // up
			case 87: // w
				moveForward = true;
				break;
			case 37: // left
			case 65: // a
				moveLeft = true; break;
			case 40: // down
			case 83: // s
				moveBackward = true;
				break;
			case 39: // right
			case 68: // d
				moveRight = true;
				break;
			case 32: // space
				canJump = false;
				break;
		}
	};

	/* Function inside init on key up */
	var onKeyUp = function ( event ) {
		switch( event.keyCode ) {
			case 38: // up
			case 87: // w
				moveForward = false;
				break;
			case 37: // left
			case 65: // a
				moveLeft = false;
				break;
			case 40: // down
			case 83: // s
				moveBackward = false;
				break;
			case 39: // right
			case 68: // d
				moveRight = false;
				break;
		}
	};

	/* Add listeners */
	document.addEventListener( 'keydown', onKeyDown, false );
	document.addEventListener( 'keyup', onKeyUp, false );
	window.addEventListener( 'resize', onWindowResize, false );
}

function initGun() {
	var mtlLoader = new THREE.MTLLoader();
	mtlLoader.setPath( 'objects/G36/' );
	mtlLoader.load( 'G36.mtl', function( materials ) {
		materials.preload();
		var objLoader = new THREE.OBJLoader();
		objLoader.setMaterials( materials );
		objLoader.setPath( 'objects/G36/' );
		objLoader.load( 'G36.obj', function ( object ) {
			weapon = object;
			weapon.rotation.y += -(Math.PI * 90) / 180;
			weapon.position.y = -3;	
			weapon.position.z = -4;	
			weapon.position.x = +4;
			weapon.scale.set(0.75,0.75,0.75);	
			scene.add( weapon );
		});
	});
}	

function intitCrosshair(){
	var material = new THREE.LineBasicMaterial({ color: 0xAAFFAA });

	/* Velikost merka */
	var x = 0.05, y = 0.05;
	var geometry = new THREE.Geometry();

	/* Točke merka */
	geometry.vertices.push(new THREE.Vector3(0, y, 0));
	geometry.vertices.push(new THREE.Vector3(0, -y, 0));
	geometry.vertices.push(new THREE.Vector3(0, 0, 0));
	geometry.vertices.push(new THREE.Vector3(x, 0, 0));    
	geometry.vertices.push(new THREE.Vector3(-x, 0, 0));

	/* Narišemo črte */
	crosshair = new THREE.Line( geometry, material );

	/* Postavimo malo predse */
	crosshair.position.z = -2;

	/* Dodamo v sceno */
	scene.add(crosshair);
}

function initTerrain(){
	var mtlLoader = new THREE.MTLLoader();
	mtlLoader.setPath( 'maps/' );
	mtlLoader.load( 'awp_india.mtl', function( materials ) {
		materials.preload();
		var objLoader = new THREE.OBJLoader();
		objLoader.setMaterials( materials );
		objLoader.setPath( 'maps/' );
		objLoader.load( 'awp_india.obj', function ( object ) {
			object.position.y = 0;	
			object.position.z = 0;	
			object.position.x = 0;
			object.scale.set(0.12,0.12,0.12);
			object.position.set(0, 12, -125);
			scene.add( object );
		});
	});
}

function onWindowResize() {
	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix();
	renderer.setSize( window.innerWidth, window.innerHeight );
}

function animate() {
	setInterval(requestAnimationFrame( animate ));
	//mesh.rotation.x += 0.005;
		if(controlsEnabled){
			var time = Date.now();
			var delta = ( time - prevTime ) / 1000;
			if ( moveForward ){
				//velocity.z -= MOVE_FACTOR;
				controls.getObject().translateZ(-MOVE_FACTOR );
				//weapon.position.z = controls.getObject().position.z-8;
			} 
			if ( moveBackward ){
				//velocity.z += MOVE_FACTOR;
				controls.getObject().translateZ(MOVE_FACTOR );
				//weapon.position.z = controls.getObject().position.z-8;
			}
			if ( moveLeft ){
				//velocity.x -= MOVE_FACTOR;
				controls.getObject().translateX(-MOVE_FACTOR );
				//weapon.position.x = controls.getObject().position.x;
			} 
			if ( moveRight ){
				//velocity.x += MOVE_FACTOR;
				controls.getObject().translateX(MOVE_FACTOR);
				//weapon.position.x = controls.getObject().position.x;
			}
		if(weapon != null)
			weapon.position.y += Math.sin(time * 0.0006) * 0.001;	
	}
	prevTime = time;
	controls.getObject().add(weapon);
	controls.getObjectX().add(weapon);
	controls.getObject().add(crosshair);
	controls.getObjectX().add(crosshair);
	renderer.render( scene, camera );
}