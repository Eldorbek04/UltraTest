<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <meta name="description"
        content="ULTRA TEST - Bilimingizni zamonaviy AI testlar orqali sinab ko'ring. Dasturlash, tillar va aniq fanlar bo'yicha professional testlar.">
    <meta name="keywords" content="test, online test, dasturlash, uzbekistan test, ai test, bilim sinash">
    <meta name="author" content="Ultra Test Team">

    <meta property="og:title" content="ULTRA TEST — Bilimingizni onlayn sinang">
    <meta property="og:description" content="Dasturlash va boshqa fanlardan eng qiziqarli testlar to'plami.">
    <meta property="og:image" content="./img/og-preview.jpg">
    <meta property="og:type" content="website">

    <meta name="theme-color" content="#38bdf8" />
    
    <style>
        :root {
            --primary: #38bdf8;
            --bg-dark: #0f172a;
            --card-bg: #1e293b;
            --input-bg: #141d2e;
        }

        body {
            background-color: var(--bg-dark);
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .auth-card {
            background: var(--card-bg);
            width: 340px;
            padding: 24px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mini-logo {
            font-size: 30px;
            font-weight: 800;
            color: white;
            margin-bottom: 5px;
            text-align: center;
        }

        .mini-logo span {
            color: var(--primary);
        }

        .header p {
            color: #94a3b8;
            font-size: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input {
            background: var(--input-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 10px 14px;
            border-radius: 10px;
            color: white;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.2);
        }

        .error {
            color: #f87171;
            font-size: 12px;
        }

        .btn-submit {
            background: linear-gradient(90deg, #38bdf8, #2563eb);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 5px;
        }

        .btn-submit:hover {
            filter: brightness(1.2);
            transform: scale(1.02);
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #94a3b8;
            text-align: center;
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
        }
    </style>
</head>
<body>

@yield('content')

</body>
</html>
