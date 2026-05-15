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
    <title><?php echo $part['name']; ?> - Surface AR</title>
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00d4ff;
            --secondary: #0052cc;
            --bg: #030b1a;
            --card-bg: rgba(10, 31, 61, 0.8);
            --text: #e6f1ff;
        }
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: var(--bg);
            font-family: 'Outfit', sans-serif;
        }

        .logo-small {
            position: absolute;
            top: 2rem;
            right: 2rem;
            width: 40px;
            height: 40px;
            object-fit: contain;
            z-index: 100;
        }

        model-viewer {
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, #0a1f3d 0%, #030b1a 100%);
        }

        .ui-overlay {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 10;
            pointer-events: none;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            text-decoration: none;
            padding: 0.8rem 1.2rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 600;
            pointer-events: auto;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(0, 242, 255, 0.2);
            border-color: var(--primary);
        }

        .info-card {
            background: var(--card-bg);
            color: #fff;
            padding: 1.5rem;
            border-radius: 20px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 320px;
            pointer-events: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            transition: all 0.3s ease;
        }

        .info-toggle {
            display: none;
            width: 45px;
            height: 45px;
            background: var(--secondary);
            color: white;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--primary);
            cursor: pointer;
            pointer-events: auto;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.4);
        }

        @media (max-width: 600px) {
            .info-toggle {
                display: flex;
            }

            .ui-overlay {
                top: 0.5rem;
                left: 0.5rem;
                right: 0.5rem;
                width: auto;
                display: flex;
                flex-direction: column;
                gap: 0.8rem;
            }

            .back-btn {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
                margin-bottom: 0;
                width: fit-content;
            }

            .info-card {
                width: 95%;
                max-width: 350px;
                margin: 0 auto;
                max-height: 50vh;
                overflow-y: auto;
                padding: 1rem;
                background: rgba(3, 11, 26, 0.95);
                border-radius: 15px;
                display: none; /* Hidden by default on mobile */
                opacity: 0;
                transform: translateY(-10px);
                scrollbar-width: thin;
                scrollbar-color: var(--primary) transparent;
            }

            .info-card.active {
                display: block;
                opacity: 1;
                transform: translateY(0);
            }

            .info-card h1 {
                font-size: 1.1rem;
                margin-bottom: 0.2rem;
                line-height: 1.2;
            }

            .info-card p {
                font-size: 0.75rem;
                margin-bottom: 0.5rem;
                line-height: 1.4;
            }

            .spec-grid {
                grid-template-columns: auto 1fr;
                gap: 0.1rem 0.8rem;
                font-size: 0.7rem;
            }

            .logo-small {
                top: 0.7rem;
                right: 0.7rem;
                width: 35px;
                height: 35px;
            }

            .ar-button {
                bottom: 1.5rem;
                padding: 1rem 2rem;
                font-size: 1rem;
                width: 90%;
                display: flex !important; /* Force show */
            }
        }

        .info-card h1 {
            margin: 0 0 0.5rem 0;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .info-card p {
            margin: 0 0 1rem 0;
            font-size: 0.9rem;
            color: #ccc;
            line-height: 1.5;
        }

        .spec-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            font-size: 0.8rem;
        }

        .spec-item {
            color: #999;
        }

        .spec-value {
            color: #fff;
            font-weight: 600;
        }

        /* Hotspot Styling */
        .hotspot {
            background: var(--primary);
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 10px rgba(0, 242, 255, 0.5);
            width: 24px;
            height: 24px;
            cursor: pointer;
            padding: 0;
            transition: transform 0.3s ease;
        }

        .hotspot:hover {
            transform: scale(1.3);
            background: #fff;
        }

        .hotspot-annotation {
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            position: absolute;
            transform: translate(20px, -50%);
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            pointer-events: none;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
            border: 1px solid var(--primary);
        }

        .hotspot:hover .hotspot-annotation {
            opacity: 1;
        }

        .ar-button {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(45deg, #0066ff, #00f2ff);
            color: #000;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0, 242, 255, 0.3);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 100;
        }

        #ar-prompt {
            position: absolute;
            bottom: 6rem;
            left: 50%;
            transform: translateX(-50%);
            display: none;
        }

        model-viewer[ar-status="session-started"] > #ar-prompt {
            display: block;
        }

        .coord-helper {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0,0,0,0.5);
            color: #00f2ff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 10px;
            pointer-events: none;
        }
    </style>
</head>
<body>

<img src="assets/logo.png" alt="Logo" class="logo-small">

<div class="ui-overlay">
    <div style="display: flex; gap: 10px; align-items: center;">
        <a href="index.php" class="back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Dashboard
        </a>
        <button class="info-toggle" id="infoToggle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        </button>
    </div>
    
    <div class="info-card" id="infoCard">
        <h1><?php echo $part['name']; ?></h1>
        <p><?php echo $part['description']; ?></p>
        <div class="spec-grid">
            <?php foreach($part['specs'] as $key => $val): ?>
                <div class="spec-item"><?php echo $key; ?>:</div>
                <div class="spec-value"><?php echo $val; ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="coord-helper">Tip: Click model to log hotspot coordinates to console</div>

<model-viewer 
    id="part-viewer"
    src="<?php echo $part['model']; ?>" 
    ar 
    ar-placement="floor"
    ar-scale="auto"
    ar-modes="webxr scene-viewer quick-look" 
    camera-controls 
    poster="assets/thumbs/ttisarvr.png" 
    shadow-intensity="1" 
    auto-rotate 
    camera-orbit="45deg 55deg 2.5m"
    alt="A 3D model of a <?php echo $part['name']; ?>">
    
    <?php if(isset($part['hotspots'])): ?>
        <?php foreach($part['hotspots'] as $hs): ?>
            <button class="hotspot" slot="<?php echo $hs['slot']; ?>" data-position="<?php echo $hs['position']; ?>" data-normal="<?php echo $hs['normal']; ?>">
                <div class="hotspot-annotation"><?php echo $hs['text']; ?></div>
            </button>
        <?php endforeach; ?>
    <?php endif; ?>

    <button slot="ar-button" class="ar-button">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
        LAUNCH SURFACE AR
    </button>

    <div id="ar-prompt">
        <img src="https://modelviewer.dev/shared-assets/icons/hand.png" width="80">
    </div>
</model-viewer>

<script>
    const modelViewer = document.querySelector("#part-viewer");

    // Check for Secure Context (Required for WebXR in Chrome)
    if (window.location.protocol !== 'https:' && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
        console.warn("AR Warning: WebXR (Chrome AR) requires HTTPS to function on mobile devices. If you are using an IP address, please use HTTPS or test on localhost.");
    }

    // AR Status Logging
    modelViewer.addEventListener('ar-status', (event) => {
        console.log(`AR Status changed to: ${event.detail.status}`);
        if (event.detail.status === 'failed') {
            alert("AR failed to launch. Please ensure you are using a compatible device and an HTTPS connection.");
        }
    });

    // Click anywhere on model to find coordinates
    modelViewer.addEventListener('click', (event) => {
        const rect = modelViewer.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        const positionAndNormal = modelViewer.positionAndNormalFromPoint(x, y);

        if (positionAndNormal) {
            const {position, normal} = positionAndNormal;
            console.log(`Hotspot found! Position: ${position.toString()} Normal: ${normal.toString()}`);
            // You can use these values in data.php
        }
    });

    const infoToggle = document.querySelector("#infoToggle");
    const infoCard = document.querySelector("#infoCard");

    infoToggle.addEventListener('click', () => {
        infoCard.classList.toggle('active');
        // Optional: change icon color when active
        infoToggle.style.backgroundColor = infoCard.classList.contains('active') ? 'var(--primary)' : 'var(--secondary)';
        infoToggle.style.color = infoCard.classList.contains('active') ? '#030b1a' : '#fff';
    });

    // Hotspots now rely on CSS hover state for display, no popup needed.
</script>

</body>
</html>
