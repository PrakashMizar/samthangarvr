<?php include 'includes/data.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Samthang ARVR - Trainee Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00d4ff;
            --secondary: #0052cc;
            --bg: #030b1a; /* Deeper Navy */
            --navy-dark: #05162d;
            --navy-light: #0a1f3d;
            --card-bg: rgba(10, 31, 61, 0.6);
            --text: #e6f1ff;
            --text-muted: #8892b0;
            --accent: #64ffda;
            --glass: rgba(10, 31, 61, 0.4);
            --glass-border: rgba(100, 255, 218, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(0, 82, 204, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, #030b1a 0%, #05162d 100%);
            overflow-x: hidden;
        }

        header {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--glass-border);
            backdrop-filter: blur(15px);
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(3, 11, 26, 0.8);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
        }

        .header-titles {
            text-align: left;
        }

        h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(to right, #fff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p.subtitle {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .parts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .logo-container {
                flex-direction: column;
                gap: 0.5rem;
            }

            .header-titles {
                text-align: center;
            }

            h1 {
                font-size: 1.4rem;
            }

            p.subtitle {
                font-size: 0.8rem;
            }

            .parts-grid {
                grid-template-columns: 1fr; /* Single column on mobile */
                gap: 1rem;
            }

            .part-thumb {
                height: 180px;
            }
        }

        .part-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            backdrop-filter: blur(5px);
            display: flex;
            flex-direction: column;
        }

        .part-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 15px 30px rgba(0, 212, 255, 0.15);
        }

        .part-thumb {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid var(--glass-border);
            background: #05162d;
        }

        .part-content {
            padding: 1.5rem;
        }

        .part-name {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #fff;
        }

        .part-desc {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 4.8rem; /* Ensures cards stay somewhat aligned while allowing more text */
        }

        .part-actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            flex: 1;
            padding: 0.8rem;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-surface {
            background: linear-gradient(45deg, var(--secondary), var(--primary));
            color: #000;
        }

        .btn-marker {
            background: transparent;
            border: 1px solid var(--glass-border);
            color: var(--text);
        }

        .btn:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        .btn-marker:hover {
            background: var(--glass-border);
            border-color: var(--text);
        }

        .stats-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.6);
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            backdrop-filter: blur(5px);
            border: 1px solid var(--glass-border);
        }

        .header-search {
            flex: 1;
            max-width: 400px;
            margin: 0 2rem;
        }

        #partSearch {
            width: 100%;
            padding: 0.7rem 1.2rem;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: #fff;
            font-family: inherit;
            outline: none;
            transition: all 0.3s ease;
        }

        #partSearch:focus {
            border-color: var(--primary);
            background: rgba(10, 31, 61, 0.6);
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.2);
        }

        @media (max-width: 768px) {
            .header-search {
                width: 100%;
                margin: 0.5rem 0;
                order: 3;
            }
        }

        footer {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .part-card {
            animation: fadeIn 0.6s ease out backwards;
        }

        <?php foreach(range(1, 10) as $i): ?>
        .part-card:nth-child(<?php echo $i; ?>) { animation-delay: <?php echo $i * 0.1; ?>s; }
        <?php endforeach; ?>

    </style>
</head>
<body>

<header>
    <div class="logo-container">
        <img src="assets/logo.png" alt="Samthang Logo" class="logo-img">
        <div class="header-titles">
            <h1>Samthang AR</h1>
            <p class="subtitle">Digital Twin Training</p>
        </div>
    </div>
    <div class="header-search">
        <input type="text" id="partSearch" placeholder="Search components..." onkeyup="filterParts()">
    </div>
</header>

<div class="container">
    <div class="parts-grid" id="partsGrid">
        <?php foreach ($parts as $part): ?>
        <div class="part-card" data-name="<?php echo strtolower($part['name']); ?>">
            <div class="stats-badge"><?php echo $part['specs']['Complexity']; ?> Complexity</div>
            <img src="<?php echo $part['thumb']; ?>" alt="<?php echo $part['name']; ?>" class="part-thumb" onerror="this.src='https://placehold.co/400x300/1a2230/00f2ff?text=<?php echo urlencode($part['name']); ?>'">
            <div class="part-content">
                <h2 class="part-name"><?php echo $part['name']; ?></h2>
                <p class="part-desc"><?php echo $part['description']; ?></p>
                <div class="part-actions">
                    <a href="surface.php?id=<?php echo $part['id']; ?>" class="btn btn-surface">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        Surface AR
                    </a>
                    <a href="marker.php?id=<?php echo $part['id']; ?>" class="btn btn-marker">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="12" cy="12" r="3"></circle></svg>
                        Marker AR
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer>
    &copy; 2026 Samthang AR - Powered by TTIS
</footer>

<script>
    function filterParts() {
        const filter = document.getElementById('partSearch').value.toLowerCase();
        const cards = document.querySelectorAll('.part-card');

        cards.forEach(card => {
            const name = card.dataset.name;
            if (name.includes(filter)) {
                card.style.display = "";
                card.style.animation = "fadeIn 0.3s ease forwards";
            } else {
                card.style.display = "none";
            }
        });
    }
</script>

</body>
</html>
