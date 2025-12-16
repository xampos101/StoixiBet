/**
 * Three.js 3D Casino Scene
 * Creates animated 3D playing cards, chips, and dice in the hero section
 */

let scene, camera, renderer, controls;
let cards = [];
let chips = [];
let dice = [];
let mouse = { x: 0, y: 0 };
let targetMouse = { x: 0, y: 0 };

// Check WebGL support
function initThreeScene() {
    const canvas = document.getElementById('hero-canvas');
    if (!canvas) return;
    
    // Check for WebGL support
    try {
        const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
        if (!gl) {
            console.warn('WebGL not supported, using fallback');
            document.getElementById('casino-fallback')?.classList.add('active');
            return;
        }
    } catch (e) {
        console.warn('WebGL error, using fallback');
        document.getElementById('casino-fallback')?.classList.add('active');
        return;
    }

    // Scene setup
    scene = new THREE.Scene();
    scene.fog = new THREE.Fog(0x0f1419, 10, 50);

    // Camera setup
    const container = canvas.parentElement;
    const width = container.clientWidth;
    const height = container.clientHeight;
    
    camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
    camera.position.set(0, 0, 8);

    // Renderer setup
    renderer = new THREE.WebGLRenderer({
        canvas: canvas,
        alpha: true,
        antialias: true,
        powerPreference: "high-performance"
    });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x000000, 0);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;

    // Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
    scene.add(ambientLight);

    const directionalLight1 = new THREE.DirectionalLight(0x3b82f6, 1);
    directionalLight1.position.set(5, 5, 5);
    directionalLight1.castShadow = true;
    scene.add(directionalLight1);

    const directionalLight2 = new THREE.DirectionalLight(0x06b6d4, 0.8);
    directionalLight2.position.set(-5, -5, 5);
    scene.add(directionalLight2);

    // Volumetric lighting (god rays)
    const pointLight = new THREE.PointLight(0x3b82f6, 2, 20);
    pointLight.position.set(0, 0, 5);
    scene.add(pointLight);

    // Create 3D objects
    createCards();
    createChips();
    createDice();

    // Mouse tracking for parallax
    document.addEventListener('mousemove', onMouseMove);
    window.addEventListener('resize', onWindowResize);

    // Animation loop
    animate();
}

// Create 3D Playing Cards
function createCards() {
    const cardGeometry = new THREE.PlaneGeometry(1.2, 1.8);
    
    // Card materials with different suits
    const suits = [
        { color: 0xffffff, symbol: '♠' }, // Spades
        { color: 0xff0000, symbol: '♥' }, // Hearts
        { color: 0xffffff, symbol: '♣' }, // Clubs
        { color: 0xff0000, symbol: '♦' }  // Diamonds
    ];

    for (let i = 0; i < 8; i++) {
        const suit = suits[i % 4];
        const material = new THREE.MeshStandardMaterial({
            color: suit.color,
            metalness: 0.3,
            roughness: 0.4,
            emissive: new THREE.Color(suit.color).multiplyScalar(0.1)
        });

        const card = new THREE.Mesh(cardGeometry, material);
        
        // Random position
        card.position.set(
            (Math.random() - 0.5) * 8,
            (Math.random() - 0.5) * 6,
            (Math.random() - 0.5) * 4
        );
        
        // Random rotation
        card.rotation.set(
            Math.random() * Math.PI * 0.2,
            Math.random() * Math.PI * 0.2,
            Math.random() * Math.PI * 0.2
        );

        // Store animation properties
        card.userData = {
            baseRotation: { ...card.rotation },
            basePosition: { ...card.position },
            floatSpeed: 0.5 + Math.random() * 0.5,
            floatAmount: 0.3 + Math.random() * 0.3
        };

        scene.add(card);
        cards.push(card);
    }
}

// Create 3D Casino Chips
function createChips() {
    const chipGeometry = new THREE.CylinderGeometry(0.4, 0.4, 0.1, 32);
    
    for (let i = 0; i < 6; i++) {
        const material = new THREE.MeshStandardMaterial({
            color: i % 2 === 0 ? 0x3b82f6 : 0x06b6d4,
            metalness: 0.8,
            roughness: 0.2,
            emissive: new THREE.Color(i % 2 === 0 ? 0x3b82f6 : 0x06b6d4).multiplyScalar(0.2)
        });

        const chip = new THREE.Mesh(chipGeometry, material);
        
        chip.position.set(
            (Math.random() - 0.5) * 6,
            (Math.random() - 0.5) * 4,
            (Math.random() - 0.5) * 3
        );

        chip.userData = {
            basePosition: { ...chip.position },
            spinSpeed: 1 + Math.random() * 2,
            bounceSpeed: 0.8 + Math.random() * 0.4,
            bounceAmount: 0.2 + Math.random() * 0.2
        };

        scene.add(chip);
        chips.push(chip);
    }
}

// Create 3D Dice
function createDice() {
    const diceGeometry = new THREE.BoxGeometry(0.5, 0.5, 0.5);
    
    for (let i = 0; i < 4; i++) {
        const material = new THREE.MeshStandardMaterial({
            color: 0xffffff,
            metalness: 0.5,
            roughness: 0.3,
            emissive: 0xffffff,
            emissiveIntensity: 0.1
        });

        const die = new THREE.Mesh(diceGeometry, material);
        
        die.position.set(
            (Math.random() - 0.5) * 5,
            (Math.random() - 0.5) * 3,
            (Math.random() - 0.5) * 2
        );

        die.userData = {
            basePosition: { ...die.position },
            rollSpeed: 2 + Math.random() * 3,
            rollDirection: new THREE.Vector3(
                (Math.random() - 0.5) * 0.02,
                (Math.random() - 0.5) * 0.02,
                (Math.random() - 0.5) * 0.02
            )
        };

        scene.add(die);
        dice.push(die);
    }
}

// Mouse movement handler for parallax
function onMouseMove(event) {
    targetMouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    targetMouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
}

// Smooth mouse interpolation
function updateMouse() {
    mouse.x += (targetMouse.x - mouse.x) * 0.05;
    mouse.y += (targetMouse.y - mouse.y) * 0.05;
}

// Animation loop
function animate() {
    requestAnimationFrame(animate);
    
    const time = Date.now() * 0.001;
    
    updateMouse();

    // Animate cards - floating and rotating
    cards.forEach((card, index) => {
        const userData = card.userData;
        
        // Floating animation
        card.position.y = userData.basePosition.y + Math.sin(time * userData.floatSpeed + index) * userData.floatAmount;
        
        // Rotation animation
        card.rotation.x = userData.baseRotation.x + Math.sin(time * 0.5 + index) * 0.1;
        card.rotation.y = userData.baseRotation.y + Math.cos(time * 0.7 + index) * 0.1;
        card.rotation.z = userData.baseRotation.z + Math.sin(time * 0.3 + index) * 0.05;
        
        // Parallax effect based on mouse
        card.position.x += (mouse.x * 0.5 - card.position.x) * 0.02;
        card.position.y += (mouse.y * 0.5 - card.position.y) * 0.02;
    });

    // Animate chips - spinning and bouncing
    chips.forEach((chip, index) => {
        const userData = chip.userData;
        
        // Spinning
        chip.rotation.y += 0.02 * userData.spinSpeed;
        
        // Bouncing
        chip.position.y = userData.basePosition.y + Math.abs(Math.sin(time * userData.bounceSpeed + index)) * userData.bounceAmount;
        
        // Parallax
        chip.position.x += (mouse.x * 0.3 - chip.position.x) * 0.01;
    });

    // Animate dice - rolling
    dice.forEach((die, index) => {
        const userData = die.userData;
        
        // Rolling rotation
        die.rotation.x += userData.rollDirection.x * userData.rollSpeed;
        die.rotation.y += userData.rollDirection.y * userData.rollSpeed;
        die.rotation.z += userData.rollDirection.z * userData.rollSpeed;
        
        // Parallax
        die.position.x += (mouse.x * 0.4 - die.position.x) * 0.015;
        die.position.y += (mouse.y * 0.4 - die.position.y) * 0.015;
    });

    // Camera parallax
    camera.position.x += (mouse.x * 0.5 - camera.position.x) * 0.03;
    camera.position.y += (mouse.y * 0.3 - camera.position.y) * 0.03;
    camera.lookAt(scene.position);

    renderer.render(scene, camera);
}

// Window resize handler
function onWindowResize() {
    const container = document.querySelector('.hero-visual');
    if (!container || !camera || !renderer) return;
    
    const width = container.clientWidth;
    const height = container.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
}

// Initialize when DOM is ready and after loading screen
function initThreeSceneDelayed() {
    // Wait for loading screen to finish
    setTimeout(() => {
        initThreeScene();
    }, 500);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initThreeSceneDelayed);
} else {
    initThreeSceneDelayed();
}

