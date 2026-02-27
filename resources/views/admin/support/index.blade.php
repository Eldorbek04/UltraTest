@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
    Qo'llab-quvvatlash — ULTRA TEST
    @endsection
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #0f172a;
            --card-bg: #1e293b;
            --accent: #38bdf8;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --input-bg: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            margin-left: 300px;
        }

        .header-title {
            margin-bottom: 30px;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .header-title p {
            color: var(--text-muted);
            margin: 0;
        }

        /* Support Layout */
        .support-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 25px;
        }

        @media (max-width: 850px) {
            .support-grid { grid-template-columns: 1fr; }
        }

        .support-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid var(--border);
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: var(--accent);
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: white;
            font-family: inherit;
            box-sizing: border-box;
            transition: 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .btn-send {
            background: var(--accent);
            color: #000;
            border: none;
            padding: 14px 25px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        .btn-send:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* Contact Methods */
        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            text-decoration: none;
            color: white;
            margin-bottom: 15px;
            border: 1px solid transparent;
            transition: 0.3s;
        }

        .contact-item:hover {
            border-color: var(--accent);
            background: rgba(56, 189, 248, 0.05);
        }

        .icon-box {
            width: 45px;
            height: 45px;
            background: rgba(56, 189, 248, 0.1);
            color: var(--accent);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .contact-info b {
            display: block;
            font-size: 15px;
        }

        .contact-info span {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* FAQ Section */
        .faq-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        details {
            margin-bottom: 10px;
            cursor: pointer;
        }

        summary {
            font-weight: 500;
            padding: 10px 0;
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        summary::after {
            content: '+';
            color: var(--accent);
            font-size: 20px;
        }

        details[open] summary::after {
            content: '-';
        }

        .faq-content {
            color: var(--text-muted);
            font-size: 14px;
            padding-bottom: 10px;
            line-height: 1.6;
            width: 50%;
        }

        
    </style>
</head>
<body>

    <div class="container">
        <header class="header-title">
            <h1>Qo'llab-quvvatlash markazi</h1>
            <p>Savollaringiz bo'lsa, biz bilan bog'laning Telefon raqamingiz yoki telegram useringizni qoldiring biz siz bilan aloqaga chiqamiz.</p>
        </header>

        <div class="support-grid">
            <div class="support-card">
                <div class="card-title">
                    <i class="fas fa-paper-plane"></i>
                    Xabar yuborish
                </div>
                <form action="{{ route('admin.support.send_message') }}" method="POST">
                @csrf
                    <!-- <div class="form-group">
                        <label>Mavzu</label>
                        <select class="form-control">
                            <option>Texnik muammo</option>
                            <option>To'lovlar bo'yicha</option>
                            <option>Hamkorlik</option>
                            <option>Boshqa</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label>Xabaringiz</label>
                        <textarea class="form-control" name="message" id="message" placeholder="Muammo yoki savol haqida batafsil ma'lumot bering..."></textarea>
                    </div>
                    <button type="submit" class="btn-send">Xabarni yuborish</button>
                </form>
            </div>

            <div class="support-card">
                <div class="card-title">
                    <i class="fas fa-headset"></i>
                    Tezkor aloqa
                </div>
                
                <a href="https://t.me/rayimjonov_eldorbek" class="contact-item">
                    <div class="icon-box"><i class="fab fa-telegram-plane"></i></div>
                    <div class="contact-info">
                        <b>Telegram admin</b>
                        <span>@ultra_admin (24/7)</span>
                    </div>
                </a>

                <a href="tel:+998979090219" class="contact-item">
                    <div class="icon-box"><i class="fas fa-phone-alt"></i></div>
                    <div class="contact-info">
                        <b>Telefon raqam</b>
                        <span>+998 97 909 02 19</span>
                    </div>
                </a>

                <div class="faq-section">
                    <div class="card-title" style="font-size: 16px;">Ko'p beriladigan savollar</div>
                    
                    <details>
                        <summary>Testni qanday sotib olaman?</summary>
                        <div class="faq-content">
                            Profil orqali hisobingizni to'ldiring va kerakli testni ishlang.
                        </div>
                    </details>

                    <details>
                        <summary>Natijalarni qayerdan ko'raman?</summary>
                        <div class="faq-content">
                            Barcha topshirilgan testlar natijalari ishlangan test yakunlagandan keyin pdf korinishida taqdim etiladi.
                    </details>
                </div>
                
            </div>
        </div>
    </div>

@endsection