import * as THREE from 'three';
import { FBXLoader } from 'three/examples/jsm/loaders/FBXLoader.js';

let scene, camera, renderer, model, mixer, clock;
let currentAction = null;

export function initCharacter() {
    const container = document.getElementById('character-container');
    if (!container) {
        console.error('Character container not found');
        return;
    }

    try {
        console.log('Initializing character...');

        // Scene setup
        scene = new THREE.Scene();
        scene.background = null;

        // Camera setup
        camera = new THREE.PerspectiveCamera(
            75,
            container.clientWidth / container.clientHeight,
            0.1,
            1000
        );
        camera.position.set(0, 0, 2.5);

        // Renderer setup
        renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(container.clientWidth, container.clientHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.shadowMap.enabled = true;
        container.appendChild(renderer.domElement);

        // Lighting
        const ambientLight = new THREE.AmbientLight(0xffffff, 1.0);
        scene.add(ambientLight);

        const directionalLight = new THREE.DirectionalLight(0xffffff, 0.9);
        directionalLight.position.set(5, 10, 5);
        directionalLight.castShadow = true;
        directionalLight.shadow.mapSize.width = 2048;
        directionalLight.shadow.mapSize.height = 2048;
        scene.add(directionalLight);

        // Load FBX model
        const fbxLoader = new FBXLoader();
        const modelPath = '/character/Waving Gesture.fbx';
        
        console.log('Loading FBX from:', modelPath);

        fbxLoader.load(
            modelPath,
            function(object) {
                console.log('FBX loaded successfully', object);
                model = object;
                
                // Scale and position
                model.scale.set(0.012, 0.012, 0.012);
                model.position.set(0, -1.2, 0);
                
                // Apply material adjustments for better visibility
                model.traverse(function(child) {
                    if (child.isMesh) {
                        child.castShadow = true;
                        child.receiveShadow = true;
                    }
                });
                
                scene.add(model);

                // Setup mixer for animations
                mixer = new THREE.AnimationMixer(model);
                clock = new THREE.Clock();

                // Setup animations to play once
                if (object.animations && object.animations.length > 0) {
                    console.log('Animations found:', object.animations.length);
                    currentAction = mixer.clipAction(object.animations[0]);
                    currentAction.loop = THREE.LoopOnce;
                    currentAction.clampWhenFinished = true;
                    currentAction.play();
                }

                // Add hover interaction to replay animation
                const characterParentContainer = container.parentElement;
                if (characterParentContainer) {
                    characterParentContainer.addEventListener('mouseenter', () => {
                        if (currentAction && object.animations && object.animations.length > 0) {
                            currentAction.reset();
                            currentAction.play();
                        }
                    });
                }

                animate();
            },
            function(progress) {
                const percent = (progress.loaded / progress.total * 100).toFixed(2);
                console.log('Loading progress:', percent + '%');
            },
            function(error) {
                console.error('Error loading FBX model:', error);
                container.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #666; text-align: center; padding: 20px; font-size: 14px;"><p>Character loading...</p></div>';
            }
        );

        // Handle window resize
        window.addEventListener('resize', onWindowResize);

        function onWindowResize() {
            if (!container) return;
            const width = container.clientWidth;
            const height = container.clientHeight;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height);
        }
    } catch (err) {
        console.error('Error initializing character:', err);
    }
}

function animate() {
    requestAnimationFrame(animate);

    // Update mixer if available
    if (mixer && clock) {
        const delta = clock.getDelta();
        mixer.update(delta);
    }

    if (renderer && scene && camera) {
        renderer.render(scene, camera);
    }
}

// Initialize when DOM is ready
export function startCharacterInit() {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCharacter);
    } else {
        initCharacter();
    }
}

export function changeCharacterPose(posePath) {
    const container = document.getElementById('character-container');
    if (!container || !scene) {
        console.error('Container or scene not found');
        return;
    }

    // Remove old model
    if (model) {
        scene.remove(model);
        model = null;
    }

    // Load new FBX model
    const fbxLoader = new FBXLoader();
    
    console.log('Loading FBX pose from:', posePath);

    fbxLoader.load(
        posePath,
        function(object) {
            console.log('FBX pose loaded successfully', object);
            model = object;
            
            // Scale and position
            model.scale.set(0.012, 0.012, 0.012);
            model.position.set(0, -1.2, 0);
            
            // Apply material adjustments for better visibility
            model.traverse(function(child) {
                if (child.isMesh) {
                    child.castShadow = true;
                    child.receiveShadow = true;
                }
            });
            
            scene.add(model);

            // Setup mixer for animations
            mixer = new THREE.AnimationMixer(model);
            clock = new THREE.Clock();

            // Setup animations to play once
            if (object.animations && object.animations.length > 0) {
                console.log('Animations found:', object.animations.length);
                currentAction = mixer.clipAction(object.animations[0]);
                currentAction.loop = THREE.LoopOnce;
                currentAction.clampWhenFinished = true;
                currentAction.play();
            }
        },
        function(progress) {
            const percent = (progress.loaded / progress.total * 100).toFixed(2);
            console.log('Loading progress:', percent + '%');
        },
        function(error) {
            console.error('Error loading FBX pose:', error);
        }
    );
}

// Make changeCharacterPose globally available
window.changeCharacterPose = changeCharacterPose;
