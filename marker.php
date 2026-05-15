<?php 
include 'includes/data.php'; 
$id = $_GET['id'] ?? 'engine-01';
$part = $parts[$id] ?? reset($parts);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $part['name']; ?> - Marker AR</title>
    <!-- A-Frame and AR.js -->
    <script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script>
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
    <script src="https://raw.githack.com/fcor/arjs-gestures/master/dist/gestures.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <script>
        // Component to auto-center models that have off-center origins
        AFRAME.registerComponent('center-model', {
            init: function () {
                this.el.addEventListener('model-loaded', () => {
                    const obj3D = this.el.getObject3D('mesh');
                    if (!obj3D) return;
                    
                    // Calculate bounding box
                    const box = new THREE.Box3().setFromObject(obj3D);
                    const center = box.getCenter(new THREE.Vector3());
                    const size = box.getSize(new THREE.Vector3());
                    
                    // Offset the inner mesh to perfectly center it 
                    // and place its bottom right on the marker
                    obj3D.position.x = -center.x;
                    obj3D.position.y = -center.y + (size.y / 2);
                    obj3D.position.z = -center.z;
                });
            }
        });
    </script>
    <style>
        :root {
            --primary: #00d4ff;
            --secondary: #0052cc;
            --bg: #030b1a;
            --glass: rgba(0, 0, 0, 0.7);
        }
        body { margin: 0; overflow: hidden; font-family: 'Outfit', sans-serif; background: var(--bg); }
        
        .ui-overlay {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .logo-img-small {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--glass);
            color: #fff;
            text-decoration: none;
            padding: 0.8rem 1.2rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(0, 242, 255, 0.3);
            border-color: var(--primary);
        }

        .marker-hint {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--glass);
            color: #fff;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 0.9rem;
            white-space: nowrap;
            z-index: 998;
            border: 1px solid var(--primary);
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.2);
            text-align: center;
        }
    </style>
</head>
<body>

<div class="ui-overlay">
    <img src="assets/logo.png" alt="Logo" class="logo-img-small">
    <a href="index.php" class="back-btn">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Dashboard
    </a>
</div>

<div class="marker-hint">
    Point camera at Marker to see the 3D Model
    <div id="loader-progress" style="font-size: 0.7rem; color: #aaa; margin-top: 5px;">Initializing AR...</div>
</div>

<a-scene 
    embedded 
    vr-mode-ui="enabled: false"
    arjs="sourceType: webcam; sourceWidth:1280; sourceHeight:960; displayWidth: 1280; displayHeight: 960; debugUIEnabled: false; detectionMode: mono_and_matrix; matrixCodeType: 3x3;"
    gesture-detector
    renderer="logarithmicDepthBuffer: true;">
    
    <a-assets timeout="60000">
        <a-asset-item id="model" src="<?php echo $part['model']; ?>"></a-asset-item>
    </a-assets>

    <!-- Custom Pattern Marker -->
    <a-marker 
        type="pattern" 
        url="<?php echo $part['marker']; ?>" 
        id="mainMarker" 
        smooth="true" 
        smoothCount="10" 
        smoothTolerance=".01" 
        smoothThreshold="5"
        raycaster="objects: .clickable"
        emitevents="true"
        cursor="fuse: false; rayOrigin: mouse;">
        
        <a-entity 
            id="modelEntity"
            gltf-model="#model" 
            center-model
            scale="<?php echo $part['marker_scale'] ?? '1 1 1'; ?>" 
            position="0 0 0"
            rotation="0 0 0"
            class="clickable"
            gesture-handler="minScale: 0.01; maxScale: 10"
            animation="property: rotation; to: 0 360 0; loop: true; dur: 20000; easing: linear; pauseEvents: markerLost; resumeEvents: markerFound"
            visible="false">
        </a-entity>
    </a-marker>

    <a-entity camera></a-entity>
</a-scene>

<script>
    const marker = document.querySelector('#mainMarker');
    const hint = document.querySelector('.marker-hint');
    const loaderProgress = document.querySelector('#loader-progress');
    const modelEntity = document.querySelector('#modelEntity');

    // Handle Model Loading Progress
    document.querySelector('a-assets').addEventListener('progress', (e) => {
        const progress = Math.round(e.detail.progress * 100);
        loaderProgress.innerHTML = `Downloading Model: ${progress}%`;
    });

    document.querySelector('a-assets').addEventListener('loaded', () => {
        loaderProgress.innerHTML = `Model Ready! Ready for Tracking.`;
        loaderProgress.style.color = '#00ff00';
        modelEntity.setAttribute('visible', true);
    });

    marker.addEventListener('markerFound', () => {
        hint.style.borderColor = '#00ff00';
        hint.childNodes[0].textContent = 'MODEL LOADED ✅ ';
    });

    marker.addEventListener('markerLost', () => {
        hint.style.borderColor = 'var(--primary)';
        hint.childNodes[0].textContent = 'Point camera at Marker to see the 3D Model ';
    });
</script>

</body>
</html>
