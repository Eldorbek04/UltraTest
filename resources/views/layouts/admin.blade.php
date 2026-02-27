<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="icon" type="image/png" href="./image/logotitl.png">

    <meta name="description"
        content="ULTRA TEST - Bilimingizni zamonaviy AI testlar orqali sinab ko'ring. Dasturlash, tillar va aniq fanlar bo'yicha professional testlar.">
    <meta name="keywords" content="test, online test, dasturlash, uzbekistan test, ai test, bilim sinash">
    <meta name="author" content="Ultra Test Team">

    <meta property="og:title" content="ULTRA TEST — Bilimingizni onlayn sinang">
    <meta property="og:description" content="Dasturlash va boshqa fanlardan eng qiziqarli testlar to'plami.">
    <meta property="og:image" content="./img/og-preview.jpg">
    <meta property="og:type" content="website">

    <meta name="theme-color" content="#38bdf8" />

    <link rel="stylesheet" href="{{ asset('./assets/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


</head>

<body>
    <style>
        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .chart-container,
        .quick-actions,
        .activity-feed {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Grafik Placeholder */
        .placeholder-chart {
            height: 150px;
            display: flex;
            align-items: flex-end;
            gap: 10px;
            padding-top: 20px;
        }

        .bar {
            flex: 1;
            background: linear-gradient(to top, var(--accent), #0072ff);
            border-radius: 4px 4px 0 0;
            opacity: 0.7;
        }

        /* Tezkor tugmalar */
        .action-buttons {
            display: grid;
            gap: 10px;
            margin-top: 15px;
        }

        .action-item {
            padding: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: white;
            cursor: pointer;
            text-align: left;
            transition: 0.3s;
        }

        .action-item:hover {
            background: var(--accent);
            color: black;
        }

        /* Faollik ro'yxati */
        .activity-list {
            list-style: none;
            margin-top: 15px;
        }

        .activity-list li {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .activity-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .blue {
            background: rgba(0, 210, 255, 0.1);
            color: #00d2ff;
        }

        .green {
            background: rgba(0, 255, 136, 0.1);
            color: #00ff88;
        }

        .activity-text b {
            display: block;
            font-size: 14px;
        }

        .activity-text span {
            font-size: 12px;
            color: #6c7293;
        }
    </style>
    <style>
        :root {
    --blue-neon: #00d1ff;
    --bg-dark: #0d1117;
    }

    body {
    background-color: var(--bg-dark);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    }

    .loader {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    position: relative;
    
    /* Gradien aylana hosil qilish */
    background: conic-gradient(from 0deg, transparent 20%, var(--blue-neon));
    
    /* O'rtasini teshish (maskalash) */
    -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 8px), #fff 0);
    mask: radial-gradient(farthest-side, transparent calc(100% - 8px), #fff 0);
    
    /* Aylanish animatsiyasi */
    animation: spin 1.2s linear infinite;
    }

    /* Loaderning uchidagi yorqin nuqta (Glow) */
    .loader::after {
    content: "";
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 8px;
    height: 8px;
    background: var(--blue-neon);
    border-radius: 50%;
    box-shadow: 0 0 15px var(--blue-neon), 0 0 30px var(--blue-neon);
    }

    @keyframes spin {
    to {
        transform: rotate(360deg);
    }
    }
    </style>


@yield('content')

<script>
    // Loader elementini tanlab olamiz
const loader = document.querySelector('.loader');

// Sahifa to'liq yuklanganda loaderni yashirish
window.addEventListener('load', () => {
    // Ozgina kechikish bilan o'chirish (effekt uchun)
    setTimeout(() => {
        loader.style.display = 'none';
        console.log("Sahifa yuklandi!");
    }, 2000); 
});
</script>
<script src="{{ asset('./assets/js/main.js') }}"></script>
<script src="{{ asset('./assets/js/validet.js') }}"></script>
</body>

</html>